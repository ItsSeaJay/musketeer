// Define some utility functions to be used by the installer
function recursive_copy($source, $destination)
{
	$dir = opendir($source);
	mkdir($destination);

	while (FALSE !== ($file = readdir($dir)))
	{
		if (($file != '.') AND ($file != '..'))
		{
			if (is_dir($source.'/'.$file))
			{
				recursive_copy($source.'/'.$file, $destination.'/'.$file);
			}
			else
			{
				copy($source.'/'.$file, $destination.'/'.$file);
			}
		}
	}

	closedir($dir);
}

function recursive_delete($source)
{
	$dir = opendir($source);

    while(FALSE !== ($file = readdir($dir)))
    {
        if (($file != '.') && ($file != '..'))
        {
            $full = $source . '/' . $file;

            if (is_dir($full))
            {
                recursive_delete($full);
            }
            else
            {
                unlink($full);
            }
        }
    }

    closedir($dir);
    rmdir($source);
}

/**
 * An installer for the CodeIgniter framework
 */
class Installer {

	public function __construct($templates = array())
	{
		$this->templates = array();
	}

	/**
	* Installs the CodeIgniter framework to the given destination
	*/
	public function install($destination = '')
	{
		// Use the latest release number to construct the download URL
		// (assuming that each entry is in chronological order with the newest first)
		// e.g. https://github.com/bcit-ci/CodeIgniter/archive/3.1.9.zip
		$latest_version = $this->get_latest_version();
		$download_url = 'https://github.com/bcit-ci/CodeIgniter/archive/'.$latest_version.'.zip';

		// Download that version of CodeIgniter to the server as a `.zip` file
		$file_name = 'CodeIgniter-'.$latest_version.'.zip';
		$folder_name = $destination.'CodeIgniter-'.$latest_version;
		file_put_contents($file_name, fopen($download_url, 'r'));

		// Unzip the contents of that file to the absolute path
		$zip = new ZipArchive;

		if (($zip->open($file_name)) === TRUE)
		{
			$zip->extractTo($destination);
			$zip->close();
		}

		// Get the site configuration from the previous form
		$config['base_url'] = $_POST['base_url'] ?? 'http://example.com/';

		// Replace the information in the 'config' template with the user's configuration
		$templates['config'] = str_replace('{base_url}', $config['base_url'], $templates['config']);

		// Store that information in the appropriate file
		file_put_contents($folder_name.'application\\config\\config.php', $templates['config']);

		// Do the same for the database configuration
		$db['username'] = $_POST['db_username'] ?? '';
		$db['password'] = $_POST['db_password'] ?? '';

		$templates['database'] = str_replace('{username}', $db['username'], $templates['database']);
		$templates['database'] = str_replace('{password}', $db['password'], $templates['database']);

		file_put_contents($folder_name.'application\\config\\database.php', $templates['database']);

		// Write the index file to the folder root from its template
		// TODO: ensure the index file is in it's own folder
		file_put_contents($destination.'index.php', $templates['index']);

		// Move the necessary files into place unless they already exist
		if (!is_dir($destination.'application') AND !is_dir($destination.'\\system'))
		{
			recursive_copy($destination.'CodeIgniter-'.$latest_version.'\\application', $destination.'\\application');
			recursive_copy($destination.'CodeIgniter-'.$latest_version.'\\system', $destination.'\\system');
		}

		copy($destination.'CodeIgniter-'.$latest_version.'\\index.php', $destination.'\\index.php');

		// Clean up any excess files left behind by the process
		recursive_delete($destination.'CodeIgniter-'.$latest_version);
		unlink($destination.$file_name);

		// Redirect the user to their new site
		header('Location: index.php');
	}

	/**
	* Gets the latest version of CodeIgniter from the Atom releases feed
	*/
	private function get_latest_version()
	{
		$feed = simplexml_load_file('https://github.com/bcit-ci/CodeIgniter/releases.atom');
		$latest_version = $feed->entry[0]->title;

		return $latest_version;
	}
}

if (isset($_POST['base_url']))
{
	$installer = new Installer();
	$installer->install(dirname(__FILE__).'\\');
}
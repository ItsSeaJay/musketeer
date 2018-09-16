<?php
function recursive_copy($source, $destination)
{
	if (!is_dir($destination))
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
}

function recursive_delete($source)
{
	$dir = opendir($source);

    while(FALSE !== ($file = readdir($dir)) )
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

if (isset($_POST['submit']))
{
	$feed = simplexml_load_file('https://github.com/bcit-ci/CodeIgniter/releases.atom');

	// Use the latest release number to construct the download URL
	// (assuming that each entry is in chronological order with the newest first)
	// e.g. https://github.com/bcit-ci/CodeIgniter/archive/3.1.9.zip
	$latest_version = $feed->entry[0]->title;
	$download_url = 'https://github.com/bcit-ci/CodeIgniter/archive/'.$latest_version.'.zip';

	// Download that version of CodeIgniter to the server as a `.zip` file
	$file_name = 'CodeIgniter-'.$latest_version.'.zip';
	$folder_name = dirname(__FILE__).'\\'.'CodeIgniter-'.$latest_version;
	file_put_contents($file_name, fopen($download_url, 'r'));

	// Unzip the contents of that file to the absolute path
	$zip = new ZipArchive;

	if (($zip->open($file_name)) === TRUE)
	{
		$zip->extractTo(dirname(__FILE__));
		$zip->close();
	}

	// Get a list of templates needed to complete the installation process
	$templates = array();
	$templates['config'] = file_get_contents(dirname(__FILE__).'\\templates\\config.txt');
	$templates['database'] = file_get_contents(dirname(__FILE__).'\\templates\\database.txt');

	// Get the site configuration from the previous form
	$config['base_url'] = $_POST['base_url'] ?? 'http://example.com/';

	// Replace the information in the 'config' template with the user's configuration
	$templates['config'] = str_replace('{base_url}', $config['base_url'], $templates['config']);

	// Store that information in the appropriate file
	file_put_contents($folder_name.'\\application\\config\\config.php', $templates['config']);

	// Do the same for the database configuration
	$db['username'] = $_POST['db_username'] ?? '';
	$db['password'] = $_POST['db_password'] ?? '';

	$templates['database'] = str_replace('{username}', $db['username'], $templates['database']);
	$templates['database'] = str_replace('{password}', $db['password'], $templates['database']);

	file_put_contents($folder_name.'\\application\\config\\database.php', $templates['database']);

	// Move the necessary files into place
	recursive_copy(dirname(__FILE__).'\\CodeIgniter-'.$latest_version.'\\application', dirname(__FILE__).'\\application');
	recursive_copy(dirname(__FILE__).'\\CodeIgniter-'.$latest_version.'\\system', dirname(__FILE__).'\\system');

	// Clean up any excess files left behind by the process
	recursive_delete(dirname(__FILE__).'\\'.'CodeIgniter-'.$latest_version);
	unlink(dirname(__FILE__).'\\'.$file_name);

	// Redirect the user to their new site
	header('Location: index.php');
}
else
{
	// Show the form instead
	$form = file_get_contents(dirname(__FILE__).'\\templates\\form.txt');
	echo $form;
}
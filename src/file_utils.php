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
<?php
// Stop the script if any of the applications files exist
if (file_exists('index.php') OR is_dir('application') OR is_dir('system'))
{
	exit('Installation process has already been run.');
}
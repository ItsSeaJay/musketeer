<?php
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
$templates['config'] = file_get_contents(dirname(__FILE__).'\templates\config.txt');

// Get the configuration from the previous form
$config['base_url'] = $_POST['base_url'] ?? 'http://example.com/';

// Replace the information in the 'config' template with the user's configuration
$templates['config'] = str_replace('{base_url}', $config['base_url'], $templates['config']);

// Store that information in the appropriate file
file_put_contents($folder_name.'\\application\\config\\config.php', $templates['config']);

// Clean up any excess files left by the process
unlink(dirname(__FILE__).'\\'.$file_name);
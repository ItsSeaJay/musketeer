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

// Clean up any excess files left behind by the process
unlink(dirname(__FILE__).'\\'.$file_name);

// Redirect the user to their new site
header('Location: '.'CodeIgniter-'.$latest_version);
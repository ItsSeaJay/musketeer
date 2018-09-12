<?php
// Obtain the list of CodeIgniter releases as an Atom feed
$feed = simplexml_load_file('https://github.com/bcit-ci/CodeIgniter/releases.atom');

// Use the latest release number to construct the download URL
// (assuming that each entry is in chronological order with the newest first)
// e.g. https://github.com/bcit-ci/CodeIgniter/archive/3.1.9.zip
$latest_version = $feed->entry[0]->title;
$download_url = 'https://github.com/bcit-ci/CodeIgniter/archive/'.$latest_version.'.zip';

// Download that version of CodeIgniter to the server as a `.zip` file
$file_name = 'CodeIgniter-'.$latest_version.'.zip';
file_put_contents($file_name, fopen($download_url, 'r'));

// Unzip the contents of that file to the root
$zip = new ZipArchive;

if (($zip->open($file_name)) === TRUE)
{
	$zip->extractTo('');
	$zip->close();

	echo 'Extracted zip archive';
}
<?php
// Obtain the list of CodeIgniter releases as an Atom feed
$feed = simplexml_load_file('https://github.com/bcit-ci/CodeIgniter/releases.atom');
$releases = array();

foreach ($feed->entry as $entry)
{
	array_push($releases, $entry->title);
}
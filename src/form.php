<!-- This is the form where the user can specify config information -->
<html>
	<head>
		<title>Installer</title>
	</head>
	<body>
		<div class="container">
			<h1>Configuration</h1>
			<form class="u-full-width" action="install.php" method="POST">
				<input name="submit" type="hidden" value="true">

				<h2>Files</h2>
				<!-- Destination -->
				<b><p><label for="destination">Destination Folder*</label></p></b>
				<p>
					Where to install CodeIgniter and its files on the server,
					followed by a forward slash `/`.
				</p>
				<input class="u-full-width" type="text" name="destination" placeholder="/var/www/html/" value="<?php echo __DIR__.'/' ?>" required>

				<hr>

				<h2>Site</h2>
				<!-- Base URL -->
				<b><p><label for="base_url">Base URL*</label></p></b>
				<p>
					This is the URL which CodeIgniter uses to find itself.
					It's usually the domain name of your website, followed by a
					forward slash `/`, unless you're installing it into a subfolder.
				</p>
				<input class="u-full-width" type="text" name="base_url" placeholder="http://example.com/" value="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>" required>
				<!-- Index File -->
				<b><p><label for="base_url">Separate Index File*</label></p></b>
				<p>
					Whether the index file should have a folder to itself.
					This is turned on by default to prevent people from accessing
					sensitive files, but may not be supported on all servers.
				</p>
				<input class="u-full-width" type="checkbox" name="index_file" checked>

				<hr>

				<h2>Database</h2>
				<!-- Database Username -->
				<b><p><label for="database_username">Database Username*</label></p></b>
				<p>
					The name of the account used to connect to your database.
				</p>
				<input class="u-full-width" type="text" name="db_username" placeholder="root" required>
				<!-- Database Username -->
				<b><p><label for="db_password">Database Password</label></p></b>
				<p>
					The password used to secure your database account,
					if you have one.
				</p>
				<input class="u-full-width" type="password" name="db_password" value="root">

				<hr>

				<input class="button-primary" type="submit">
			</form>
		</div>
	</body>
</html>
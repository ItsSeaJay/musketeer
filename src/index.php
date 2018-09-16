<!-- This is the form where the user can specify config information -->
<html>
	<head>
		<title>Installer</title>
	</head>
	<body>
		<h1>Configuration</h1>
		<form action="install.php" method="POST">
			<h2>Site</h2>
			<!-- Base URL -->
			<div class="form_group">
				<b><p><label for="base_url">Base URL*</label></p></b>
				<p>
					This is the URL which CodeIgniter uses to find itself.
					It's usually the domain name of your website, followed by a
					forward slash `/`, unless you're installing it into a subfolder.
				</p>
				<input type="text" name="base_url" placeholder="http://example.com/" required>
			</div>

			<h2>Database</h2>
			<!-- Database Username -->
			<div class="form_group">
				<b><p><label for="database_username">Database Username*</label></p></b>
				<p>
					The name of the account used to connect to your database
				</p>
				<input type="text" name="database_username" placeholder="root" required>
			</div>
			<!-- Database Username -->
			<div class="form_group">
				<b><p><label for="db_password">Database Password</label></p></b>
				<p>
					This is the URL which CodeIgniter uses to find itself.
					This is usually <?php?>
				</p>
				<input type="password" name="db_password" value="root">
			</div>

			<input type="submit">
		</form>
	</body>
</html>
<?php
?>
<!-- This is the form where the user can specify con -->
<html>
	<head>
		<title>Installer</title>
	</head>
	<body>
		<form action="install.php" method="POST">
			<b><label for="base_url">Base URL</label></b>
			<p>
				This is the URL which CodeIgniter uses to check it's files exist.
			</p>
			<input type="text" name="base_url">

			<input type="submit">
		</form>
	</body>
</html>
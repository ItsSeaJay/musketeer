import shutil
import os

def file_get_contents(path):
	if os.path.isfile(path):
		with open(path, 'r') as file:
			contents = file.read()

			return contents

def file_put_contents(path, contents):
	if os.path.isfile(path):
		os.remove(path)

	with open(path, 'w') as file:
		file.write(contents)

def make_dir(path):
	if not os.path.exists(path):
		os.makedirs(path)

def install(destination):
	# Get all of the necessary files for building
	templates = {
		'config': file_get_contents('src/templates/config.txt'),
		'database': file_get_contents('src/templates/database.txt'),
		'index': file_get_contents('src/templates/index.txt')
	}
	installer = file_get_contents('src/installer.php')
	form = file_get_contents('src/form.php')
	start_tag = file_get_contents('src/start_tag.php')
	end_tag = file_get_contents('src/end_tag.php')

	# Compile the built file as a string
	build = start_tag

	for key, template in templates.items():
		build += template + '\n'

	build += installer + '\n'
	build += end_tag + '\n'
	build += form + '\n'

	# Create a folder for the build if it doesn't already exist
	make_dir(destination)

	# Write the built file to the new folder
	file_put_contents(destination + 'installer.php', build)

	# Alert the user
	print('Built installer at ' + destination)

# Run the install function
install('build')
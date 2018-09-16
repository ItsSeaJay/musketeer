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
	templates = {
		'config': file_get_contents('src/templates/config.txt'),
		'database': file_get_contents('src/templates/database.txt'),
		'index': file_get_contents('src/templates/index.txt')
	}
	installer = file_get_contents('src/installer.php')
	build = ''

	# Compile the built file as a string
	for template in templates:
		build += template

	build += template

	# Create a folder for the build if it doesn't already exist
	make_dir(destination)

	# Write the built file to the new folder
	file_put_contents('build/install.php', build)

	print('Built!')


install('build')
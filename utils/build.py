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
	templates_array = file_get_contents('src/templates_array.php')

	# Define the full build path
	build_path = destination + '/install.php'

	# Compile the built file as a single, formatted string
	build = start_tag + '\n\n'
	build += '$templates = array();' + '\n\n';

	for key, template in templates.items():
		build += template + '\n\n'

	build += installer + '\n'
	build += end_tag + '\n\n'
	build += form

	# Create a folder for the build if it doesn't already exist
	make_dir(destination)

	# Write the built file to the build path
	file_put_contents(build_path, build)

	# Alert the user that the build completed
	print('Built installer at `', build_path, '`.')

if __name__ == '__main__':
	install('build')
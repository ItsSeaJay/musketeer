import os
import shutil

# Remove the build folder and its contents if they exist
if os.path.exists('build'):
	shutil.rmtree('build')

# Notify the user on the command line
print('Cleaned project folders.')
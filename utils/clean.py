import os
import shutil

# Clean out the CodeIgniter files present in the source folder
shutil.rmtree('src/application')
shutil.rmtree('src/system')
os.remove('src/index.php')
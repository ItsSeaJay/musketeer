# Musketeer
An All-in-One Installer for CodeIgniter 3

## About
**Musketeer** is a program written in PHP to make installing CodeIgniter
applications on shared hosting easier for the end user. Rather than following
the framework's standard installation process, which can be difficult and
frustrating for those unfamiliar with the language, **Musketeer** allows
for a fast installation experience right in the browser.

## Requirements
- PHP 7
- Python 3

## Building
Since editing a single source file can be difficult, **Musketeer** seperates
all of it's main files out and uses Python to stitch them all together. Building
the application is as easy as opening a command window and typing:

```
python3 utils/build.py
```

whereupon a file named `install.php` should appear in the `build` folder. A
`clean.py` script is also included for testing purposes. If you're on Windows,
there's even some batch files to reduce the amount of key presses you need.

## Usage
Upload the `install.php` file to your server and navigate to it. Once there,
fill in the form provided and push the button. If your install was successful,
you should be redirected to your new application automatically. You should then
delete `install.php` from your server.

If you decided to separate your index file, make sure to change your web root
to point to the `public` folder.
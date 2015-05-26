# e4406a-capture
Simple screen capture application for the Agilent E4406A VSA

## Packages required:

* nginx
* php5-cli
* php5-fpm

## Usage

The included php scripts present an option to retrieve the capture screenx.gif files using FTP from an Agilent E4406A Transmitter Tester.

The two options "Fetch New" or "Fetch All", will either grab only new caputured images or all the images stored - along with creating a notes.txt file with information from the supplied web form.

Screens are stored in a date/time stamped directory in files/ - so the web server must have write access to this directory.

If there is a current symlink (ie. a fetch has been performed in the past) then any images from that are displayed (and notes.txt) on the index form, along with options to download the set as a zip or tgz.

## md5list

The md5 sums of the screen files are also stored in files/md5list, so that Fetch New only stores a new set of images instead of duplicates.

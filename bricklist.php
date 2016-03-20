<?php

require 'vendor/autoload.php';
use RustyFausak\BrickList\Config;
use RustyFausak\BrickList\BrickList;

function usage()
{
	print "Usage: " . basename(__FILE__) . " <tiles file> <image file>[ <image file>[..]]\n";
	exit();
}

if (sizeof($argv) < 3) {
	usage();
}

$config = new Config($argv[1]);
$bricklist = new BrickList($config);
for ($i = 2; $i < sizeof($argv); $i++) {
	$image = $bricklist->process($argv[$i]);
	$pathinfo = pathinfo(basename($argv[$i]));
	$image->generatePlacementsImage('output-' . $pathinfo['filename'] . '.png');
}
$bricklist->outputCsv('output.csv');

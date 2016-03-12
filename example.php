<?php

require 'vendor/autoload.php';

function usage()
{
	print "Usage: " . basename(__FILE__) . " <tiles file> <image file>[ <image file>[..]]\n";
	exit();
}

if (sizeof($argv) < 3) {
	usage();
}

$config = new RustyFausak\BrickList\Config\Config($argv[1]);
$bricklist = new RustyFausak\BrickList\BrickList($config);
for ($i = 2; $i < sizeof($argv); $i++) {
	$bricklist->process($argv[$i]);
}

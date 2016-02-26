<?php

require 'vendor/autoload.php';

$config = new RustyFausak\BrickList\Config\Config();
$config->readTileFile('tiles.txt');
print_r($config);

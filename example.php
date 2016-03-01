<?php

require 'vendor/autoload.php';

$config = new RustyFausak\BrickList\Config\Config('tiles.txt');
$bricklist = new RustyFausak\BrickList\BrickList($config);
$bricklist->process('img/earth.png');

<?php

namespace RustyFausak\BrickList;

class BrickList
{
	/* @var \RustyFausak\BrickList\Config\Config */
	private $config;

	/**
	 * @param \RustyFausak\BrickList\Config\Config $config
	 */
	public function __construct(\RustyFausak\BrickList\Config\Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Reads an image at the path `$path` and processes it into a brick list.
	 *
	 * @param string $path
	 * @return
	 */
	public function process($image_path)
	{
		$image = new \RustyFausak\BrickList\Image($image_path);
	}
}

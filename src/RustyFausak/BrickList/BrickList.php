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
		if ($this->config->numTiles() == 0) {
			throw new \Exception("Cannot build a BrickList without any tiles.");
		}
	}

	/**
	 * Reads an image at the path `$path` and processes it into a brick list.
	 *
	 * @param string $path
	 * @return array of \RustyFausak\BrickList\Output\Item
	 */
	public function process($image_path)
	{
		$items = [];
		$image = new \RustyFausak\BrickList\Image($image_path, $this->config);
		$summary = $image->getSummary();
		foreach ($summary['colors'] as $hex => $_) {
			$tiles = $this->config->getTilesOfColor($hex);
			$data = [];
			foreach ($tiles as $k => $tile) {
				$data[$k] = $tile->getBrick()->getSize();
			}
			array_multisort($data, SORT_DESC, $tiles);
			foreach ($tiles as $tile) {
				$item = new \RustyFausak\BrickList\Output\Item($tile, $image->fillTile($tile));
				print $item;
				$items[] = $item;
			}
		}
		exit;
	}
}

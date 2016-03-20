<?php

namespace RustyFausak\BrickList;

class BrickList
{
	/* @var Config */
	public $config;

	/* @var array of Item */
	public $items;

	/**
	 * @param Config $config
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
		if ($this->config->numTiles() == 0) {
			throw new \Exception("Cannot build a BrickList without any tiles.");
		}
		$this->items = [];
	}

	/**
	 * Reads an image at the path `$path` and processes it into a brick list.
	 *
	 * @param string $path
	 * @return Image
	 */
	public function process($image_path)
	{
		$items = [];
		$image = new Image($image_path, $this->config);
		$summary = $image->getSummary();
		foreach ($summary['colors'] as $hex => $_) {
			$tiles = $this->config->getTilesOfColor($hex);
			$data = [];
			foreach ($tiles as $k => $tile) {
				$data[$k] = $tile->brick->getSize();
			}
			array_multisort($data, SORT_DESC, $tiles);
			foreach ($tiles as $tile) {
				$item = new Item($tile, $image->fillTile($tile));
				if ($item->quantity) {
					$items[] = $item;
				}
			}
		}
		$this->merge($items);
		return $image;
	}

	/**
	 * @param array of Item
	 */
	public function merge($new_items)
	{
		foreach ($new_items as $new_item) {
			$found = false;
			foreach ($this->items as $item) {
				if (Tile::match($new_item->tile, $item->tile)) {
					$item->quantity += $new_item->quantity;
					$found = true;
					break;
				}

			}
			if (!$found) {
				$this->items[] = $new_item;
			}
		}
	}

	/**
	 * @param string $file_path
	 */
	public function outputCsv($file_path)
	{
		$fh = fopen($file_path, 'w+');
		if (!$fh) {
			throw new \Exception("Output file path '" . $file_path . "' is not writable.");
		}
		fputcsv($fh, ['color', 'brick', 'quantity']);
		foreach ($this->items as $item) {
			fputcsv($fh, [$item->tile->color->name, $item->tile->brick, $item->quantity]);
		}
		fclose($fh);
	}
}

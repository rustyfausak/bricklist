<?php

namespace RustyFausak\BrickList;

class Image
{
	/* @var array of array of array of Pixel */
	private $data;

	/**
	 * @param string $path
	 * @param \RustyFausak\BrickList\Config\Config $config
	 */
	public function __construct($path, $config)
	{
		$this->data = [];
		$this->load($path, $config);
	}

	/**
	 * Reads an image at the path `$path` and loads it into this instance.
	 *
	 * @param string $path
	 * @param \RustyFausak\BrickList\Config\Config $config
	 */
	public function load($path, $config)
	{
		$this->data = [];
		$img = $this->_create($path);
		$size = getimagesize($path);
		if (!$size) {
			throw new \Exception("Could not read size from file '" . $path . "'.");
		}
		$width = array_shift($size);
		$height = array_shift($size);
		for ($y = 0; $y < $height; $y++) {
			$this->data[$y] = [];
			for ($x = 0; $x < $width; $x++) {
				$color_index = imagecolorat($img, $x, $y);
				$rgba = imagecolorsforindex($img, $color_index);
				$hex = $config->getClosestColor($rgba);
				$this->data[$y][$x] = new Pixel($hex);
			}
		}
	}

	/**
	 * @return array
	 */
	public function getSummary()
	{
		$summary = [
			'colors' => [],
			'coverage' => [
				0 => 0,
				1 => 0
			]
		];
		foreach ($this->data as $y => $row) {
			foreach ($row as $x => $pixel) {
				$hex = $pixel->getHex();
				if (!array_key_exists($hex, $summary['colors'])) {
					$summary['colors'][$hex] = 0;
				}
				$summary['colors'][$hex]++;
				$summary['coverage'][$pixel->isCovered()]++;
			}
		}
		return $summary;
	}

	/**
	 * @param Tile $tile
	 * @return int
	 */
	public function fillTile($tile)
	{
		$num = 0;
		foreach ($this->data as $y => $row) {
			foreach ($row as $x => $pixel) {
				if ($this->fitTile($tile, $x, $y)) {
					$num++;
				}
			}
		}
		return $num;
	}

	/**
	 * Attempts to fit the tile at the specified location. Returns true if it
	 * fit, false otherwise.
	 *
	 * @param Tile $tile
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	public function fitTile($tile, $x, $y)
	{
		$brick = $tile->getBrick();
		$length = $brick->getLength();
		$width = $brick->getWidth();
		$hex = $tile->getColor()->getHex();
		if ($this->_fit($hex, $x, $x + $length, $y, $y + $width)) {
			$this->_cover($x, $x + $length, $y, $y + $width);
			return true;
		}
		elseif ($this->_fit($hex, $x, $x + $width, $y, $y + $length)) {
			$this->_cover($x, $x + $width, $y, $y + $length);
			return true;
		}
		return false;
	}

	/**
	 * @param string $hex
	 * @param int $x0
	 * @param int $x1
	 * @param int $y0
	 * @param int $y1
	 * @return bool
	 */
	private function _fit($hex, $x0, $x1, $y0, $y1)
	{
		for ($y = $y0; $y < $y1; $y++) {
			for ($x = $x0; $x < $x1; $x++) {
				if ($y >= sizeof($this->data)) {
					return false;
				}
				if ($x >= sizeof($this->data[$y])) {
					return false;
				}
				if ($this->data[$y][$x]->getHex() != $hex) {
					return false;
				}
				if ($this->data[$y][$x]->isCovered()) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * @param int $x0
	 * @param int $x1
	 * @param int $y0
	 * @param int $y1
	 */
	private function _cover($x0, $x1, $y0, $y1)
	{
		for ($y = $y0; $y < $y1; $y++) {
			for ($x = $x0; $x < $x1; $x++) {
				$this->data[$y][$x]->setCovered();
			}
		}
	}

	/**
	 * Creates an image resource and returns it of the image at the given `$path`.
	 *
	 * @param string $path
	 * @return image resource
	 */
	private function _create($path)
	{
		if (!is_readable($path)) {
			throw new \Exception("Cannot open image file '" . $path . "'.");
		}
		$img = null;
		switch (exif_imagetype($path)) {
			case IMAGETYPE_PNG:
				$img = imagecreatefrompng($path);
				break;
			default:
				throw new \Exception("Cannot read image type from file '" . $path . "'.");
		}
		if (!$img) {
			throw new \Exception("Could not create image from file '" . $path . "'.");
		}
		return $img;
	}
}

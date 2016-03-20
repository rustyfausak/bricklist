<?php

namespace RustyFausak\BrickList;

class Image
{
	/* @var array of array of array of Pixel */
	public $data;

	/**
	 * @param string $path
	 * @param Config $config
	 */
	public function __construct($path, $config)
	{
		$this->data = [];
		$this->placements = [];
		$this->load($path, $config);
	}

	/**
	 * Reads an image at the path `$path` and loads it into this instance.
	 *
	 * @param string $path
	 * @param Config $config
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
				$hex = $pixel->hex;
				if (!array_key_exists($hex, $summary['colors'])) {
					$summary['colors'][$hex] = 0;
				}
				$summary['colors'][$hex]++;
				$summary['coverage'][$pixel->is_covered]++;
			}
		}
		return $summary;
	}

	/**
	 * @param string $image_path
	 */
	public function generatePlacementsImage($image_path)
	{
		$scale = 10;
		$im = imagecreatetruecolor(sizeof($this->data[0]) * $scale, sizeof($this->data) * $scale);
		if (!$im) {
			throw new \Exception("Could not intialize image.");
		}
		$border_color = imagecolorallocate($im, 0, 255, 0);
		foreach ($this->placements as $placement) {
			$rgb = Color::hexToRgb($placement['hex']);
			imagerectangle($im,
				$placement['x0'] * $scale,
				$placement['y0'] * $scale,
				$placement['x1'] * $scale,
				$placement['y1'] * $scale,
				$border_color
			);
			imagefilltoborder($im,
				$placement['x0'] * $scale + round($scale / 2),
				$placement['y0'] * $scale + round($scale / 2),
				$border_color,
				imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2])
			);
		}
		imagepng($im, $image_path);
		imagedestroy($im);
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
		if ($tile->brick->is_plate) {
			return min(1, $num);
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
		$length = $tile->brick->length;
		$width = $tile->brick->width;
		if ($this->_fit($tile, $x, $x + $length, $y, $y + $width)) {
			$this->_cover($tile, $x, $x + $length, $y, $y + $width);
			return true;
		}
		elseif ($this->_fit($tile, $x, $x + $width, $y, $y + $length)) {
			$this->_cover($tile, $x, $x + $width, $y, $y + $length);
			return true;
		}
		return false;
	}

	/**
	 * @param Tile $tile
	 * @param int $x0
	 * @param int $x1
	 * @param int $y0
	 * @param int $y1
	 * @return bool
	 */
	public function _fit($tile, $x0, $x1, $y0, $y1)
	{
		for ($y = $y0; $y < $y1; $y++) {
			for ($x = $x0; $x < $x1; $x++) {
				if ($y >= sizeof($this->data)) {
					return false;
				}
				if ($x >= sizeof($this->data[$y])) {
					return false;
				}
				if ($this->data[$y][$x]->hex != $tile->color->hex) {
					return false;
				}
				if ($this->data[$y][$x]->is_covered) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * @param Tile $tile
	 * @param int $x0
	 * @param int $x1
	 * @param int $y0
	 * @param int $y1
	 */
	public function _cover($tile, $x0, $x1, $y0, $y1)
	{
		if (!$tile->brick->is_plate) {
			$this->placements[] = [
				'hex' => $tile->color->hex,
				'x0' => $x0,
				'y0' => $y0,
				'x1' => $x1,
				'y1' => $y1
			];
		}
		for ($y = $y0; $y < $y1; $y++) {
			for ($x = $x0; $x < $x1; $x++) {
				$this->data[$y][$x]->is_covered = true;
			}
		}
	}

	/**
	 * Creates an image resource and returns it of the image at the given `$path`.
	 *
	 * @param string $path
	 * @return image resource
	 */
	public function _create($path)
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

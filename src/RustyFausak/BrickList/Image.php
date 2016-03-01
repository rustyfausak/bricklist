<?php

namespace RustyFausak\BrickList;

class Image
{
	/* @var array of array of array of RGB values */
	private $data;

	/**
	 * @param string $path
	 */
	public function __construct($path = null)
	{
		$this->data = [];
		if ($path) {
			$this->load($path);
		}
	}

	/**
	 * Reads an image at the path `$path` and loads it into this instance.
	 *
	 * @param string $path
	 */
	public function load($path)
	{
		$this->data = [];
		$img = $this->_create($path);
		$size = getimagesize($path);
		if (!$size) {
			throw new \Exception('Could not read size from file "' . $path . '".');
		}
		$width = array_shift($size);
		$height = array_shift($size);
		for ($x = 0; $x < $width; $x++) {
			$this->data[$x] = [];
			for ($y = 0; $y < $height; $y++) {
				$color_index = imagecolorat($img, $x, $y);
				$this->data[$x][$y] =
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
			throw new \Exception('Cannot open image file "' . $path . '".');
		}
		$img = null;
		switch (exif_imagetype($path)) {
			case IMAGETYPE_PNG:
				$img = imagecreatefrompng($path);
				break;
			default:
				throw new \Exception('Cannot read image type from file "' . $path . '".');
		}
		if (!$img) {
			throw new \Exception('Could not create image from file "' . $path . '".');
		}
		return $img;
	}
}

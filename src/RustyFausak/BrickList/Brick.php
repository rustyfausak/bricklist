<?php

namespace RustyFausak\BrickList;

class Brick
{
	/* @var int */
	public $length;
	/* @var int */
	public $width;
	/* @var bool */
	public $is_plate;

	/**
	 * @param int $length
	 * @param int $width
	 */
	public function __construct($length, $width, $is_plate = false)
	{
		$this->length = $length;
		$this->width = $width;
		$this->is_plate = $is_plate;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		if ($this->is_plate) {
			return 'plate';
		}
		return "{$this->length}x{$this->width}";
	}

	/**
	 * @return int
	 */
	public function getSize()
	{
		if ($this->is_plate) {
			return PHP_INT_MAX;
		}
		return $this->length * $this->width;
	}

	/**
	 * Creates a Brick from the given `$text`. Bricks are formatted like this:
	 *
	 * <length>x<width>
	 *
	 * Example:
	 * 1x1
	 *
	 * @param string $text
	 * @return Brick
	 */
	public static function fromText($text)
	{
		if (trim($text) == 'plate') {
			return new self(1, 1, true);
		}
		$parts = array_map('trim', explode('x', $text));
		if (sizeof($parts) != 2) {
			throw new \Exception("Could not build Brick from text '" . $text . "'.");
		}
		return new self(
			intval($parts[0]),
			intval($parts[1])
		);
	}
}

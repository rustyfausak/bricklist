<?php

namespace RustyFausak\BrickList\Config;

class Brick
{
	/* @var int */
	private $length;
	/* @var int */
	private $width;

	/**
	 * @param int $length
	 * @param int $width
	 */
	public function __construct($length, $width)
	{
		$this->length = $length;
		$this->width = $width;
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
		$parts = array_map('trim', explode('x', $text));
		if (sizeof($parts) != 2) {
			throw new \Exception('Could not build Brick from text "' . $text . '".');
		}
		return new self(
			intval($parts[0]),
			intval($parts[1])
		);
	}
}

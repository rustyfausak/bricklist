<?php

namespace RustyFausak\BrickList;

class Color
{
	/* @var string */
	public $name;
	/* @var string */
	public $hex;

	/**
	 * @param string $name
	 * @param string $hex
	 */
	public function __construct($name, $hex)
	{
		$this->name = $name;
		$this->hex = $hex;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return "#{$this->hex}";
	}

	/**
	 * @return array
	 */
	public function getRgb()
	{
		return self::hexToRgb($this->hex);
	}

	/**
	 * Creates a Color from the given `$text`. Colors are formatted like this:
	 *
	 * <name>#<hex>
	 *
	 * Example:
	 * blue#0057A6
	 *
	 * @param string $text
	 * @return Color
	 */
	public static function fromText($text)
	{
		$parts = array_map('trim', explode('#', $text));
		if (sizeof($parts) != 2) {
			throw new \Exception("Could not build Color from text '" . $text . "'.");
		}
		return new self(
			$parts[0],
			$parts[1]
		);
	}

	/**
	 * Converts an array containing RGB to a hex string.
	 *
	 * @param array $rgb
	 * @return string hex
	 */
	public static function rgbToHex($rgb)
	{
		if (sizeof($rgb) < 3) {
			throw new \Exception("Could not convert RGB to hex.");
		}
		return sprintf('%02x', array_shift($rgb))
			. sprintf('%02x', array_shift($rgb))
			. sprintf('%02x', array_shift($rgb));
	}

	/**
	 * Converts a hex string to an array containing the RGB values.
	 *
	 * @param string $hex
	 * @return array
	 */
	public static function hexToRgb($hex)
	{
		$hex = str_replace('#', '', $hex);
		$hex = str_split($hex);

		if (sizeof($hex) == 3) {
			$r = hexdec($hex[0] . $hex[0]);
			$g = hexdec($hex[1] . $hex[1]);
			$b = hexdec($hex[2] . $hex[2]);
		}
		elseif (sizeof($hex) == 6) {
			$r = hexdec($hex[0] . $hex[1]);
			$g = hexdec($hex[2] . $hex[3]);
			$b = hexdec($hex[4] . $hex[5]);
		}
		else {
			throw new \Exception("Could not convert hex to RGB.");
		}

		return [$r, $g, $b];
	}

	/**
	 * Compares two RGB colors and returns the "difference" as an integer.
	 *
	 * @param array $rgb1
	 * @param array $rgb2
	 * @return int
	 */
	public static function diff($rgb1, $rgb2) {
		return abs(array_shift($rgb1) - array_shift($rgb2))
			+ abs(array_shift($rgb1) - array_shift($rgb2))
			+ abs(array_shift($rgb1) - array_shift($rgb2));
	}
}

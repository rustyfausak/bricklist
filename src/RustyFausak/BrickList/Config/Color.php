<?php

namespace RustyFausak\BrickList\Config;

class Color
{
	/* @var string */
	private $name;
	/* @var string */
	private $hex;

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
			throw new \Exception('Could not build Color from text "' . $text . '".');
		}
		return new self(
			$parts[0],
			$parts[1]
		);
	}
}

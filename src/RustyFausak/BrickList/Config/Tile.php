<?php

namespace RustyFausak\BrickList\Config;

class Tile
{
	/* @var Brick */
	private $brick;
	/* @var Color */
	private $color;
	/* @var float */
	private $price;

	/**
	 * @param Brick $brick
	 * @param Color $color
	 * @param float $price
	 */
	public function __construct(Brick $brick, Color $color, $price)
	{
		$this->brick = $brick;
		$this->color = $color;
		$this->price = $price;
	}

	/**
	 * Creates a Tile from the given `$text`. Tiles are formatted like this:
	 *
	 * <brick>, <color>, <price>
	 *
	 * Example:
	 * 1x1, blue#0057A6, 0.10
	 *
	 * @param string $text
	 * @return Tile
	 */
	public static function fromText($text)
	{
		$parts = array_map('trim', explode(',', $text));
		if (sizeof($parts) != 3) {
			throw new \Exception('Could not build Tile from text "' . $text . '".');
		}
		return new self(
			Brick::fromText($parts[0]),
			Color::fromText($parts[1]),
			floatval($parts[2])
		);
	}
}

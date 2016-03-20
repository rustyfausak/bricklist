<?php

namespace RustyFausak\BrickList;

class Tile
{
	/* @var Brick */
	public $brick;
	/* @var Color */
	public $color;

	/**
	 * @param Brick $brick
	 * @param Color $color
	 */
	public function __construct(Brick $brick, Color $color)
	{
		$this->brick = $brick;
		$this->color = $color;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return "{$this->brick};{$this->color}";
	}

	/**
	 * Creates a Tile from the given `$text`. Tiles are formatted like this:
	 *
	 * <brick>, <color>
	 *
	 * Example:
	 * 1x1, blue#0057A6
	 *
	 * @param string $text
	 * @return Tile
	 */
	public static function fromText($text)
	{
		$parts = array_map('trim', explode(',', $text));
		if (sizeof($parts) != 2) {
			throw new \Exception("Could not build Tile from text '" . $text . "'.");
		}
		return new self(
			Brick::fromText($parts[0]),
			Color::fromText($parts[1])
		);
	}

	/**
	 * @param Tile $tile1
	 * @param Tile $tile2
	 * @return bool
	 */
	public static function match($tile1, $tile2)
	{
		return $tile1->brick->length == $tile2->brick->length
			&& $tile1->brick->width == $tile2->brick->width
			&& $tile1->color->hex == $tile2->color->hex;
	}
}

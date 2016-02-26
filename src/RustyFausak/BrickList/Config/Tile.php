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
	public function __construct(Brick $brick, Color $color, float $price)
	{
		$this->brick = $brick;
		$this->color = $color;
		$this->price = $price;
	}
}

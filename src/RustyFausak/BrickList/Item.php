<?php

namespace RustyFausak\BrickList;

class Item
{
	/* @var Tile $tile */
	public $tile;
	/* @var int */
	public $quantity;

	/**
	 * @param Tile $tile
	 * @param int $quantity
	 */
	public function __construct(Tile $tile, $quantity = 0)
	{
		$this->tile = $tile;
		$this->quantity = $quantity;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return "{$this->tile};{$this->quantity}";
	}
}

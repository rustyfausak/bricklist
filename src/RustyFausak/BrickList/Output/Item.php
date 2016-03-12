<?php

namespace RustyFausak\BrickList\Output;

class Item
{
	/* @var \RustyFausak\BrickList\Config\Tile $tile */
	private $tile;
	/* @var int */
	private $quantity;

	/**
	 * @param \RustyFausak\BrickList\Config\Tile $tile
	 * @param int $quantity
	 */
	public function __construct(\RustyFausak\BrickList\Config\Tile $tile, $quantity = 0)
	{
		$this->tile = $tile;
		$this->quantity = $quantity;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return "Item [\n"
			. "\tTile => {$this->tile}\n"
			. "\tQuantity => {$this->quantity}\n"
			. "]\n";
	}
}

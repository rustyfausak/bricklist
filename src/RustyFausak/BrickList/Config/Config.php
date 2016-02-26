<?php

namespace RustyFausak\BrickList\Config;

class Config
{
	/* @var array of Tile */
	private $tiles;

	/**
	 * Default constructor
	 */
	public function __construct()
	{
		$this->tiles = [];
	}

	/**
	 * @param Tile $tile
	 */
	public function addTile(Tile $tile)
	{
		$this->tiles[] = $tile;
	}
}

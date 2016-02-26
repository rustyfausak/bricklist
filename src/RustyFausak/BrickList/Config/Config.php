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
	 * Reads the file at path `$path` for tiles. Tile files are formatted with
	 * one tile per line. See `Tile.php` for tile format specification.
	 *
	 * @param string $path
	 */
	public function readTileFile($path)
	{
		$handle = fopen($path, 'r');
		if (!$handle) {
			throw new \Exception('Could not open tile file "' . $path . '" for reading.');
		}
		while (($line = fgets($handle)) !== false) {
			$this->addTile(Tile::fromText(trim($line)));
		}
		fclose($handle);
	}

	/**
	 * @param Tile $tile
	 */
	public function addTile(Tile $tile)
	{
		$this->tiles[] = $tile;
	}
}

<?php

namespace RustyFausak\BrickList\Config;

class Config
{
	/* @var array of Tile */
	private $tiles;

	/**
	 * @param string $tile_file_path
	 */
	public function __construct($tile_file_path = null)
	{
		$this->tiles = [];
		if ($tile_file_path) {
			$this->readTileFile($tile_file_path);
		}
	}

	/**
	 * Reads the file at path `$path` for tiles. Tile files are formatted with
	 * one tile per line. See `Tile.php` for tile format specification.
	 *
	 * @param string $path
	 */
	public function readTileFile($path)
	{
		$this->tiles = [];
		$handle = fopen($path, 'r');
		if (!$handle) {
			throw new \Exception('Could not open tile file "' . $path . '" for reading.');
		}
		while (($line = fgets($handle)) !== false) {
			if (!strlen(trim($line))) {
				continue;
			}
			if (strpos($line, '#') === 0) {
				continue;
			}
			$this->addTile(Tile::fromText(trim($line)));
		}
		fclose($handle);
	}

	/**
	 * @param Tile $tile
	 */
	public function addTile(Tile $tile)
	{
		array_push($this->tiles, $tile);
	}
}

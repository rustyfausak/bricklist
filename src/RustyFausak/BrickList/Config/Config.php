<?php

namespace RustyFausak\BrickList\Config;

class Config
{
	/* @var array of Tile */
	private $tiles;
	/* @var array of string hex (image color) to string hex (color in tiles) */
	private $color_cache;

	/**
	 * @param string $tile_file_path
	 */
	public function __construct($tile_file_path = null)
	{
		$this->tiles = [];
		if ($tile_file_path) {
			$this->readTileFile($tile_file_path);
		}
		$this->color_cache = [];
	}

	/**
	 * @return int
	 */
	public function numTiles()
	{
		return sizeof($this->tiles);
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
		if (!is_readable($path)) {
			throw new \Exception("Cannot open tile file '" . $path . "'.");
		}
		$handle = fopen($path, 'r');
		if (!$handle) {
			throw new \Exception("Could not open tile file '" . $path . "' for reading.");
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

	/**
	 * @return array of Tile
	 */
	public function getTilesOfColor($hex)
	{
		$tiles = [];
		foreach ($this->tiles as $tile) {
			if ($tile->getColor()->getHex() == $hex) {
				$tiles[] = $tile;
			}
		}
		return $tiles;
	}

	/**
	 * Finds the closest color to the given RGB from the tiles and returns it.
	 *
	 * @param array $rgb
	 * @return string hex
	 */
	public function getClosestColor($rgb)
	{
		$hex = Color::rgbToHex($rgb);
		if (array_key_exists($hex, $this->color_cache)) {
			return $this->color_cache[$hex];
		}
		$selected_hex = null;
		$lowest_diff = null;
		foreach ($this->tiles as $tile) {
			$tile_rgb = $tile->getColor()->getRgb();
			$diff = Color::diff($rgb, $tile_rgb);
			if ($selected_hex === null || $lowest_diff === null || $diff < $lowest_diff) {
				$selected_hex = $tile->getColor()->getHex();
				$lowest_diff = $diff;
			}
		}
		$this->color_cache[$hex] = $selected_hex;
		return $this->color_cache[$hex];

	}
}

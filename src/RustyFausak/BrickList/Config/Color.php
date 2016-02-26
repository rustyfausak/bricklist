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
	public function __construct(string $name, string $hex)
	{
		$this->name = $name;
		$this->hex = $hex;
	}
}

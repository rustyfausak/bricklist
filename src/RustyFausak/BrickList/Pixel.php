<?php

namespace RustyFausak\BrickList;

class Pixel
{
	/* @var string */
	public $hex;
	/* @var bool */
	public $is_covered;

	/**
	 * @param string $hex
	 */
	public function __construct($hex)
	{
		$this->hex = $hex;
		$this->is_covered = false;
	}
}

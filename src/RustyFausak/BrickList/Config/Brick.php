<?php

namespace RustyFausak\BrickList\Config;

class Brick
{
	/* @var int */
	private $length;
	/* @var int */
	private $width;

	/**
	 * @param int $length
	 * @param int $width
	 */
	public function __construct(int $length, int $width)
	{
		$this->length = $length;
		$this->width = $width;
	}
}

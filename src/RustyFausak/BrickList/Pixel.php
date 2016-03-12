<?php

namespace RustyFausak\BrickList;

class Pixel
{
	/* @var string */
	private $hex;
	/* @var bool */
	private $is_covered;

	/**
	 * @param string $hex
	 */
	public function __construct($hex)
	{
		$this->hex = $hex;
		$this->is_covered = false;
	}

	/**
	 * @return bool
	 */
	public function setCovered()
	{
		$this->is_covered = true;
	}

	/**
	 * @return string
	 */
	public function getHex()
	{
		return $this->hex;
	}

	/**
	 * @return bool
	 */
	public function isCovered()
	{
		return $this->is_covered;
	}
}

<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Tests\Unit\Fixtures\ValueObjects;

/**
 * Class ObjectWithToStringMethod
 * @package hollodotme\FluidValidator\Tests\Unit\Fixtures\ValueObjects
 */
class ObjectWithToStringMethod
{
	/** @var string */
	private $string;

	/**
	 * @param string $string
	 */
	public function __construct( $string )
	{
		$this->string = $string;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->string;
	}
}

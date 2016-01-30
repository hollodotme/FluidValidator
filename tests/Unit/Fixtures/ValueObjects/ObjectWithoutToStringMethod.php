<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Tests\Unit\Fixtures\ValueObjects;

/**
 * Class ObjectWithoutToStringMethod
 * @package hollodotme\FluidValidator\Tests\Unit\Fixtures\ValueObjects
 */
class ObjectWithoutToStringMethod
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
}

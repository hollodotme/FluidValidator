<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Exceptions;

/**
 * Class CheckMethodNotCallable
 * @package hollodotme\FluidValidator\Exceptions
 */
final class CheckMethodNotCallable extends FluidValidatorException
{
	/** @var string */
	private $methodName;

	/**
	 * @param string $methodName
	 *
	 * @return $this
	 */
	public function withMethodName( $methodName )
	{
		$this->methodName = $methodName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMethodName()
	{
		return $this->methodName;
	}
}
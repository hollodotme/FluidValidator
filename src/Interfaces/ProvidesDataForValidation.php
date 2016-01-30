<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Interfaces;

/**
 * Interface ProvidesDataForValidation
 * @package hollodotme\FluidValidator\Interfaces
 */
interface ProvidesDataForValidation
{
	/**
	 * @param mixed $var
	 *
	 * @return mixed
	 */
	public function getData( $var );
}
<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Interfaces;

/**
 * Interface CollectsMessages
 * @package hollodotme\FluidValidator\Interfaces
 */
interface CollectsMessages
{
	/**
	 * @param mixed $message
	 *
	 * @return bool
	 */
	public function isMessageValid( $message );

	/**
	 * @param mixed $message
	 */
	public function addMessage( $message );

	public function clearMessages();

	/**
	 * @return array
	 */
	public function getMessages();
}
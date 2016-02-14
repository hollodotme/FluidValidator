<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\MessageCollectors;

use hollodotme\FluidValidator\Interfaces\CollectsMessages;

/**
 * Class PlainArrayMessageCollector
 * @package hollodotme\FluidValidator\MessageCollectors
 */
final class ScalarListMessageCollector implements CollectsMessages
{
	/** @var array */
	private $messages = [ ];

	/**
	 * @param string|int|float|bool $message
	 *
	 * @return bool
	 */
	public function isMessageValid( $message )
	{
		return is_scalar( $message );
	}

	/**
	 * @param string|int|float|bool $message
	 */
	public function addMessage( $message )
	{
		$this->messages[] = $message;
	}

	public function clearMessages()
	{
		$this->messages = [ ];
	}

	/**
	 * @return array
	 */
	public function getMessages()
	{
		return $this->messages;
	}
}
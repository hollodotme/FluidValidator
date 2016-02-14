<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\MessageCollectors;

use hollodotme\FluidValidator\Interfaces\CollectsMessages;

/**
 * Class GroupedListMessageCollector
 * @package hollodotme\FluidValidator\MessageCollectors
 */
final class GroupedListMessageCollector implements CollectsMessages
{
	/** @var array */
	private $messages = [ ];

	/**
	 * @param mixed $message
	 *
	 * @return bool
	 */
	public function isMessageValid( $message )
	{
		if ( is_array( $message ) || ($message instanceof \Traversable) )
		{
			foreach ( $message as $key => $value )
			{
				if ( !is_scalar( $key ) || !is_scalar( $value ) )
				{
					return false;
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * @param array $message
	 */
	public function addMessage( $message )
	{
		foreach ( $message as $key => $value )
		{
			if ( isset($this->messages[ $key ]) )
			{
				$this->messages[ $key ] = array_merge( $this->messages[ $key ], [ $value ] );
			}
			else
			{
				$this->messages[ $key ] = [ $value ];
			}
		}
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
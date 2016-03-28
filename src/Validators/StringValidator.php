<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Validators;

/**
 * Class StringValidator
 * @package hollodotme\FluidValidator\Validators
 */
class StringValidator
{

	/**
	 * The nil UUID is special form of UUID that is specified to have all 128 bits set to zero.
	 * @link http://tools.ietf.org/html/rfc4122#section-4.1.7
	 */
	const UUID_NIL           = '00000000-0000-0000-0000-000000000000';

	const UUID_VALID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isString( $value )
	{
		return (is_string( $value ) === true);
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isNonEmptyString( $value )
	{
		if ( $this->isString( $value ) )
		{
			return !empty($value);
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isUuid( $value )
	{
		if ( $this->isNonEmptyString( $value ) )
		{
			if ( $value == self::UUID_NIL )
			{
				return true;
			}
			elseif ( preg_match( "#" . self::UUID_VALID_PATTERN . "#", $value ) )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isEmail( $value )
	{
		if ( $this->isNonEmptyString( $value ) )
		{
			if ( filter_var( $value, FILTER_VALIDATE_EMAIL ) )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isUrl( $value )
	{
		if ( $this->isNonEmptyString( $value ) )
		{
			return boolval( filter_var( $value, FILTER_VALIDATE_URL ) );
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isJson( $value )
	{
		if ( $this->isNonEmptyString( $value ) )
		{
			if ( (json_decode( $value ) !== null) && json_last_error() === JSON_ERROR_NONE )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed  $value
	 * @param string $regex
	 *
	 * @return bool
	 */
	public function matchesRegex( $value, $regex )
	{
		if ( $this->isString( $value ) )
		{
			return (bool)preg_match( $regex, $value );
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 * @param int   $length
	 
	 * 
*@return bool
	 */
	public function hasLength( $value, $length )
	{
		if ( $this->isString( $value ) )
		{
			return ($this->getLength( $value ) == $length);
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param string $string
	 *
	 * @return int
	 */
	private function getLength( $string )
	{
		return grapheme_strlen( $string );
	}

	/**
	 * @param mixed $value
	 * @param int   $minLength
	 *
	 * @return bool
	 */
	public function hasMinLength( $value, $minLength )
	{
		if ( $this->isString( $value ) )
		{
			return ($this->getLength( $value ) >= $minLength);
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 * @param int   $maxLength
	 
	 * 
*@return bool
	 */
	public function hasMaxLength( $value, $maxLength )
	{
		if ( $this->isString( $value ) )
		{
			return ($this->getLength( $value ) <= $maxLength);
		}
		else
		{
			return false;
		}
	}
}

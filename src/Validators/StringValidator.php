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
		if ( is_object( $value ) )
		{
			if ( !is_callable( [ $value, '__toString' ] ) )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		elseif ( !is_scalar( $value ) )
		{
			return false;
		}
		elseif ( is_bool( $value ) )
		{
			return false;
		}
		else
		{
			return true;
		}
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
			$val = trim( strval( $value ) );

			if ( $val === '' )
			{
				return false;
			}
			else
			{
				return true;
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
	public function isInt( $value )
	{
		if ( $this->isString( $value ) )
		{
			$val = strval( $value );

			if ( is_numeric( $val ) && intval( $val ) == $val )
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
	public function isUuid( $value )
	{
		if ( $this->isNonEmptyString( $value ) )
		{
			$val = strval( $value );

			if ( $val == self::UUID_NIL )
			{
				return true;
			}
			elseif ( preg_match( "#" . self::UUID_VALID_PATTERN . "#", $val ) )
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
			$val = strval( $value );

			if ( filter_var( $val, FILTER_VALIDATE_EMAIL ) )
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
			$val = strval( $value );

			return boolval( filter_var( $val, FILTER_VALIDATE_URL ) );
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
			$val = strval( $value );

			if ( (json_decode( $val ) !== null) && json_last_error() === JSON_ERROR_NONE )
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
}

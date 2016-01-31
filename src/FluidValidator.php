<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator;

use hollodotme\FluidValidator\Exceptions\CheckMethodNotCallable;
use hollodotme\FluidValidator\Interfaces\ProvidesValuesToValidate;
use hollodotme\FluidValidator\Validators\StringValidator;

/**
 * Class FluidValidator
 * @package hollodotme\FluidValidator
 * METHODSTART
 * @method FluidValidator isString($value, $message)
 * @method FluidValidator isStringOrNull($value, $message)
 * @method FluidValidator isNonEmptyString($value, $message)
 * @method FluidValidator isNonEmptyStringOrNull($value, $message)
 * @method FluidValidator isNotEmpty($value, $message)
 * @method FluidValidator isNotEmptyOrNull($value, $message)
 * @method FluidValidator isArray($value, $message)
 * @method FluidValidator isArrayOrNull($value, $message)
 * @method FluidValidator isInt($value, $message)
 * @method FluidValidator isIntOrNull($value, $message)
 * @method FluidValidator isIntInRange($value, array $range, $message)
 * @method FluidValidator isIntInRangeOrNull($value, array $range, $message)
 * @method FluidValidator isOneStringOf($value, array $list, $message)
 * @method FluidValidator isOneStringOfOrNull($value, array $list, $message)
 * @method FluidValidator isSubsetOf($values, array $list, $message)
 * @method FluidValidator isSubsetOfOrNull($values, array $list, $message)
 * @method FluidValidator isUuid($value, $message)
 * @method FluidValidator isUuidOrNull($value, $message)
 * @method FluidValidator isEqual($value1, $value2, $message)
 * @method FluidValidator isNotEqual($value1, $value2, $message)
 * @method FluidValidator isSame($value1, $value2, $message)
 * @method FluidValidator isNotSame($value1, $value2, $message)
 * @method FluidValidator isNull($value, $message)
 * @method FluidValidator isNotNull($value, $message)
 * @method FluidValidator matchesRegex($value, $regex, $message)
 * @method FluidValidator matchesRegexOrNull($value, $regex, $message)
 * @method FluidValidator hasLength($value, $length, $message)
 * @method FluidValidator hasLengthOrNull($value, $length, $message)
 * @method FluidValidator hasMinLength($value, $minLength, $message)
 * @method FluidValidator hasMinLengthOrNull($value, $minLength, $message)
 * @method FluidValidator hasMaxLength($value, $maxLength, $message)
 * @method FluidValidator hasMaxLengthOrNull($value, $maxLength, $message)
 * @method FluidValidator counts($values, $count, $message)
 * @method FluidValidator countsOrNull($values, $count, $message)
 * @method FluidValidator isEmail($value, $message)
 * @method FluidValidator isEmailOrNull($value, $message)
 * @method FluidValidator isUrl($value, $message)
 * @method FluidValidator isUrlNull($value, $message)
 * @method FluidValidator isJson($value, $message)
 * @method FluidValidator isJsonOrNull($value, $message)
 * @method FluidValidator hasKey($values, $key, $message)
 * @method FluidValidator hasKeyOrNull($values, $key, $message)
 * @method FluidValidator isDate($dateString, $format = 'Y-m-d', $message)
 * @method FluidValidator isDateOrNull($dateString, $format = 'Y-m-d', $message)
 * @method FluidValidator isTrue($value, $message)
 * @method FluidValidator isTrueOrNull($value, $message)
 * @method FluidValidator isFalse($value, $message)
 * @method FluidValidator isFalseOrNull($value, $message)
 * @method FluidValidator whenIsString($value, $continue = 1)
 * @method FluidValidator whenIsStringOrNull($value, $continue = 1)
 * @method FluidValidator whenIsNonEmptyString($value, $continue = 1)
 * @method FluidValidator whenIsNonEmptyStringOrNull($value, $continue = 1)
 * @method FluidValidator whenIsNotEmpty($value, $continue = 1)
 * @method FluidValidator whenIsNotEmptyOrNull($value, $continue = 1)
 * @method FluidValidator whenIsArray($value, $continue = 1)
 * @method FluidValidator whenIsArrayOrNull($value, $continue = 1)
 * @method FluidValidator whenIsInt($value, $continue = 1)
 * @method FluidValidator whenIsIntOrNull($value, $continue = 1)
 * @method FluidValidator whenIsIntInRange($value, array $range, $continue = 1)
 * @method FluidValidator whenIsIntInRangeOrNull($value, array $range, $continue = 1)
 * @method FluidValidator whenIsOneStringOf($value, array $list, $continue = 1)
 * @method FluidValidator whenIsOneStringOfOrNull($value, array $list, $continue = 1)
 * @method FluidValidator whenIsSubsetOf($values, array $list, $continue = 1)
 * @method FluidValidator whenIsSubsetOfOrNull($values, array $list, $continue = 1)
 * @method FluidValidator whenIsUuid($value, $continue = 1)
 * @method FluidValidator whenIsUuidOrNull($value, $continue = 1)
 * @method FluidValidator whenIsEqual($value1, $value2, $continue = 1)
 * @method FluidValidator whenIsNotEqual($value1, $value2, $continue = 1)
 * @method FluidValidator whenIsSame($value1, $value2, $continue = 1)
 * @method FluidValidator whenIsNotSame($value1, $value2, $continue = 1)
 * @method FluidValidator whenIsNull($value, $continue = 1)
 * @method FluidValidator whenIsNotNull($value, $continue = 1)
 * @method FluidValidator whenMatchesRegex($value, $regex, $continue = 1)
 * @method FluidValidator whenMatchesRegexOrNull($value, $regex, $continue = 1)
 * @method FluidValidator whenHasLength($value, $length, $continue = 1)
 * @method FluidValidator whenHasLengthOrNull($value, $length, $continue = 1)
 * @method FluidValidator whenHasMinLength($value, $minLength, $continue = 1)
 * @method FluidValidator whenHasMinLengthOrNull($value, $minLength, $continue = 1)
 * @method FluidValidator whenHasMaxLength($value, $maxLength, $continue = 1)
 * @method FluidValidator whenHasMaxLengthOrNull($value, $maxLength, $continue = 1)
 * @method FluidValidator whenCounts($values, $count, $continue = 1)
 * @method FluidValidator whenCountsOrNull($values, $count, $continue = 1)
 * @method FluidValidator whenIsEmail($value, $continue = 1)
 * @method FluidValidator whenIsEmailOrNull($value, $continue = 1)
 * @method FluidValidator whenIsUrl($value, $continue = 1)
 * @method FluidValidator whenIsUrlNull($value, $continue = 1)
 * @method FluidValidator whenIsJson($value, $continue = 1)
 * @method FluidValidator whenIsJsonOrNull($value, $continue = 1)
 * @method FluidValidator whenHasKey($values, $key, $continue = 1)
 * @method FluidValidator whenHasKeyOrNull($values, $key, $continue = 1)
 * @method FluidValidator whenIsDate($dateString, $format = 'Y-m-d', $continue = 1)
 * @method FluidValidator whenIsDateOrNull($dateString, $format = 'Y-m-d', $continue = 1)
 * @method FluidValidator whenIsTrue($value, $continue = 1)
 * @method FluidValidator whenIsTrueOrNull($value, $continue = 1)
 * @method FluidValidator whenIsFalse($value, $continue = 1)
 * @method FluidValidator whenIsFalseOrNull($value, $continue = 1)
 * METHODEND
 */
class FluidValidator
{
	/** @var int */
	private $mode;

	/** @var ProvidesValuesToValidate|null */
	private $dataProvider;

	/** @var int */
	private $skipCounter;

	/** @var bool */
	protected $passed;

	/** @var array */
	protected $messages;

	/**
	 * @param int                           $mode
	 * @param ProvidesValuesToValidate|null $dataProvider
	 */
	public function __construct( $mode = CheckMode::CONTINUOUS, ProvidesValuesToValidate $dataProvider = null )
	{
		$this->mode         = $mode;
		$this->dataProvider = $dataProvider;
		$this->reset();
	}

	/**
	 * @return $this
	 */
	public function reset()
	{
		$this->skipCounter = 0;
		$this->passed      = true;
		$this->messages    = [ ];

		return $this;
	}

	/**
	 * @param bool $expression
	 * @param int  $continue
	 *
	 * @return $this
	 */
	public function when( $expression, $continue = 1 )
	{
		if ( $this->skipCounter > 0 )
		{
			$this->skipCounter += intval( $continue ) - 1;
		}
		else
		{
			if ( !$expression )
			{
				$this->skipCounter = intval( $continue );
			}
		}

		return $this;
	}

	/**
	 * @return bool
	 */
	public function passed()
	{
		return $this->passed;
	}

	/**
	 * @return bool
	 */
	public function failed()
	{
		return !$this->passed;
	}

	/**
	 * @return array
	 */
	public function getMessages()
	{
		return $this->messages;
	}

	/**
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @throws CheckMethodNotCallable
	 * @return $this
	 */
	public function __call( $name, array $arguments )
	{
		if ( substr( $name, 0, 4 ) == 'when' )
		{
			$methodName = substr( $name, 4 );

			return $this->handleWhenMethods( $methodName, $arguments );
		}
		else
		{
			return $this->handleCheckMethods( $name, $arguments );
		}
	}

	/**
	 * @param string $methodName
	 * @param array  $arguments
	 *
	 * @throws CheckMethodNotCallable
	 * @return FluidValidator
	 */
	private function handleWhenMethods( $methodName, array $arguments )
	{
		$checkMethod = 'check' . ucfirst( preg_replace( "#OrNull$#", '', $methodName ) );
		$this->guardCheckMethodIsCallable( $checkMethod );

		$continue    = array_pop( $arguments );
		$checkResult = call_user_func_array( [ $this, $checkMethod ], $arguments );

		if ( $this->checkNullCondition( $methodName, $arguments[0] ) )
		{
			$checkResult = true;
		}

		return $this->when( $checkResult, $continue );
	}

	/**
	 * @param string $methodName
	 * @param mixed  $var
	 *
	 * @return bool
	 */
	private function checkNullCondition( $methodName, $var )
	{
		$value    = $this->getValue( $var );
		$optional = (substr( $methodName, -6 ) == 'OrNull');

		return ($optional && is_null( $value ));
	}

	/**
	 * @param string $methodName
	 * @param array  $arguments
	 *
	 * @throws CheckMethodNotCallable
	 * @return $this
	 */
	private function handleCheckMethods( $methodName, array $arguments )
	{
		$checkMethod = 'check' . ucfirst( preg_replace( "#OrNull$#", '', $methodName ) );
		$this->guardCheckMethodIsCallable( $checkMethod );

		if ( $this->skipCounter > 0 )
		{
			$this->skipCounter--;

			return $this;
		}
		elseif ( $this->mode == CheckMode::STOP_ON_FIRST_FAIL && !$this->passed )
		{
			return $this;
		}
		else
		{
			if ( $this->checkNullCondition( $methodName, $arguments[0] ) )
			{
				return $this;
			}
			else
			{
				$message = array_pop( $arguments );

				$checkResult = call_user_func_array( [ $this, $checkMethod ], $arguments );

				if ( !$checkResult )
				{
					$this->passed     = false;
					$this->messages[] = $message;
				}
			}

			return $this;
		}
	}

	/**
	 * @param string $checkMethod
	 *
	 * @throws CheckMethodNotCallable
	 */
	private function guardCheckMethodIsCallable( $checkMethod )
	{
		$checkMethod = trim( $checkMethod );

		if ( $checkMethod == 'check' || !method_exists( $this, $checkMethod ) )
		{
			throw ( new CheckMethodNotCallable )->withMethodName( $checkMethod );
		}
	}

	/**
	 * @param mixed $var
	 *
	 * @return mixed
	 */
	public function getValue( $var )
	{
		if ( $this->dataProvider instanceof ProvidesValuesToValidate )
		{
			return $this->dataProvider->getValueToValidate( $var );
		}
		else
		{
			return $var;
		}
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function checkIsString( $value )
	{
		return ( new StringValidator() )->isString( $this->getValue( $value ) );
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function checkIsNonEmptyString( $value )
	{
		return ( new StringValidator() )->isNonEmptyString( $this->getValue( $value ) );
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function checkIsNotEmpty( $value )
	{
		return !empty($this->getValue( $value ));
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function checkIsArray( $value )
	{
		return is_array( $this->getValue( $value ) );
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	protected function checkIsInt( $value )
	{
		return ( new StringValidator() )->isInt( $this->getValue( $value ) );
	}

	/**
	 * @param mixed $value
	 * @param array $range
	 *
	 * @return bool
	 */
	protected function checkIsIntInRange( $value, array $range )
	{
		if ( $this->checkIsInt( $value ) )
		{
			$val = intval( strval( $this->getValue( $value ) ) );

			return in_array( $val, $range, true );
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 * @param array $list
	 *
	 * @return bool
	 */
	protected function checkIsOneStringOf( $value, array $list )
	{
		if ( $this->checkIsString( $value ) )
		{
			$val = strval( $this->getValue( $value ) );

			return in_array( $val, $list, true );
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $values
	 * @param array $list
	 *
	 * @return bool
	 */
	protected function checkIsSubsetOf( $values, array $list )
	{
		if ( $this->checkIsArray( $values ) )
		{
			$vals = $this->getValue( $values );

			return (count( $vals ) > 0 && count( array_diff( $vals, $list ) ) == 0);
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
	protected function checkIsUuid( $value )
	{
		return ( new StringValidator() )->isUuid( $this->getValue( $value ) );
	}

	/**
	 * @param mixed $value1
	 * @param mixed $value2
	 *
	 * @return bool
	 */
	protected function checkIsEqual( $value1, $value2 )
	{
		return ($this->getValue( $value1 ) == $value2);
	}

	/**
	 * @param mixed $value1
	 * @param mixed $value2
	 *
	 * @return bool
	 */
	protected function checkIsNotEqual( $value1, $value2 )
	{
		return ($this->getValue( $value1 ) != $value2);
	}

	/**
	 * @param mixed $value1
	 * @param mixed $value2
	 *
	 * @return bool
	 */
	protected function checkIsSame( $value1, $value2 )
	{
		return ($this->getValue( $value1 ) === $value2);
	}

	/**
	 * @param mixed $value1
	 * @param mixed $value2
	 *
	 * @return bool
	 */
	protected function checkIsNotSame( $value1, $value2 )
	{
		return ($this->getValue( $value1 ) !== $value2);
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function checkIsNull( $value )
	{
		return is_null( $this->getValue( $value ) );
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function checkIsNotNull( $value )
	{
		return !is_null( $this->getValue( $value ) );
	}

	/**
	 * @param mixed  $value
	 * @param string $regex
	 *
	 * @return bool
	 */
	protected function checkMatchesRegex( $value, $regex )
	{
		if ( $this->checkIsString( $value ) )
		{
			$val = strval( $this->getValue( $value ) );

			return boolval( preg_match( $regex, $val ) );
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
	 * @return bool
	 */
	protected function checkHasLength( $value, $length )
	{
		if ( $this->checkIsString( $value ) )
		{
			$val = strval( $this->getValue( $value ) );

			return (mb_strlen( $val, '8bit' ) == $length);
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 * @param int   $minLength
	 *
	 * @return bool
	 */
	protected function checkHasMinLength( $value, $minLength )
	{
		if ( $this->checkIsString( $value ) )
		{
			$val = strval( $this->getValue( $value ) );

			return (mb_strlen( $val, '8bit' ) >= $minLength);
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
	 * @return bool
	 */
	protected function checkHasMaxLength( $value, $maxLength )
	{
		if ( $this->checkIsString( $value ) )
		{
			$val = strval( $this->getValue( $value ) );

			return (mb_strlen( $val, '8bit' ) <= $maxLength);
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param mixed $value
	 * @param int   $count
	 *
	 * @return bool
	 */
	protected function checkCounts( $value, $count )
	{
		if ( $this->checkIsArray( $value ) )
		{
			return (count( $this->getValue( $value ) ) == $count);
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
	protected function checkIsEmail( $value )
	{
		return ( new StringValidator() )->isEmail( $this->getValue( $value ) );
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function checkIsUrl( $value )
	{
		return ( new StringValidator() )->isUrl( $this->getValue( $value ) );
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function checkIsJson( $value )
	{
		return ( new StringValidator() )->isJson( $this->getValue( $value ) );
	}

	/**
	 * @param mixed $values
	 * @param mixed $key
	 *
	 * @return bool
	 */
	protected function checkHasKey( $values, $key )
	{
		if ( $this->checkIsArray( $values ) )
		{
			return array_key_exists( $key, $this->getValue( $values ) );
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param string $dateString
	 * @param string $format
	 *
	 * @return bool
	 */
	protected function checkIsDate( $dateString, $format = 'Y-m-d' )
	{
		$dateValue = $this->getValue( $dateString );
		$dateTime  = \DateTime::createFromFormat( $format, $dateValue );

		return ($dateTime && ($dateTime->format( $format ) == $dateValue));
	}

	/**
	 * @param mixed $var
	 *
	 * @return bool
	 */
	protected function checkIsTrue( $var )
	{
		return $this->getValue( $var ) === true;
	}

	/**
	 * @param mixed $var
	 *
	 * @return bool
	 */
	protected function checkIsFalse( $var )
	{
		return $this->getValue( $var ) === false;
	}
}

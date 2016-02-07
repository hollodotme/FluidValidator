[![Build Status](https://travis-ci.org/hollodotme/FluidValidator.svg?branch=master)](https://travis-ci.org/hollodotme/FluidValidator)
[![Coverage Status](https://coveralls.io/repos/hollodotme/FluidValidator/badge.svg?branch=master&service=github)](https://coveralls.io/github/hollodotme/FluidValidator?branch=master)
[![Latest Stable Version](https://poser.pugx.org/hollodotme/fluid-validator/v/stable)](https://packagist.org/packages/hollodotme/fluid-validator) 
[![Total Downloads](https://poser.pugx.org/hollodotme/fluid-validator/downloads)](https://packagist.org/packages/hollodotme/fluid-validator) 
[![Latest Unstable Version](https://poser.pugx.org/hollodotme/fluid-validator/v/unstable)](https://packagist.org/packages/hollodotme/fluid-validator) 
[![License](https://poser.pugx.org/hollodotme/fluid-validator/license)](https://packagist.org/packages/hollodotme/fluid-validator)

# FluidValidator

Validating values with a fluid interfaced class

## Installation

```
composer require "hollodotme/fluid-validator" "~1.0.0"
```

## Available validation methods

```php
public function isString( $value, $message ) : FluidValidator;
public function isStringOrNull( $value, $message ) : FluidValidator;
public function isNonEmptyString( $value, $message ) : FluidValidator;
public function isNonEmptyStringOrNull( $value, $message ) : FluidValidator;
public function isNotEmpty( $value, $message ) : FluidValidator;
public function isNotEmptyOrNull( $value, $message ) : FluidValidator;
public function isArray( $value, $message ) : FluidValidator;
public function isArrayOrNull( $value, $message ) : FluidValidator;
public function isInt( $value, $message ) : FluidValidator;
public function isIntOrNull( $value, $message ) : FluidValidator;
public function isIntInRange( $value, array $range, $message ) : FluidValidator;
public function isIntInRangeOrNull( $value, array $range, $message ) : FluidValidator;
public function isOneStringOf( $value, array $list, $message ) : FluidValidator;
public function isOneStringOfOrNull( $value, array $list, $message ) : FluidValidator;
public function isSubsetOf( $values, array $list, $message ) : FluidValidator;
public function isSubsetOfOrNull( $values, array $list, $message ) : FluidValidator;
public function isUuid( $value, $message ) : FluidValidator;
public function isUuidOrNull( $value, $message ) : FluidValidator;
public function isEqual( $value1, $value2, $message ) : FluidValidator;
public function isNotEqual( $value1, $value2, $message ) : FluidValidator;
public function isSame( $value1, $value2, $message ) : FluidValidator;
public function isNotSame( $value1, $value2, $message ) : FluidValidator;
public function isNull( $value, $message ) : FluidValidator;
public function isNotNull( $value, $message ) : FluidValidator;
public function matchesRegex( $value, $regex, $message ) : FluidValidator;
public function matchesRegexOrNull( $value, $regex, $message ) : FluidValidator;
public function hasLength( $value, $length, $message ) : FluidValidator;
public function hasLengthOrNull( $value, $length, $message ) : FluidValidator;
public function hasMinLength( $value, $minLength, $message ) : FluidValidator;
public function hasMinLengthOrNull( $value, $minLength, $message ) : FluidValidator;
public function hasMaxLength( $value, $maxLength, $message ) : FluidValidator;
public function hasMaxLengthOrNull( $value, $maxLength, $message ) : FluidValidator;
public function counts( $values, $count, $message ) : FluidValidator;
public function countsOrNull( $values, $count, $message ) : FluidValidator;
public function isEmail( $value, $message ) : FluidValidator;
public function isEmailOrNull( $value, $message ) : FluidValidator;
public function isUrl( $value, $message ) : FluidValidator;
public function isUrlNull( $value, $message ) : FluidValidator;
public function isJson( $value, $message ) : FluidValidator;
public function isJsonOrNull( $value, $message ) : FluidValidator;
public function hasKey( $values, $key, $message ) : FluidValidator;
public function hasKeyOrNull( $values, $key, $message ) : FluidValidator;
public function isDate( $dateString, $format = 'Y-m-d', $message ) : FluidValidator;
public function isDateOrNull( $dateString, $format = 'Y-m-d', $message ) : FluidValidator;
public function isTrue( $value, $message ) : FluidValidator;
public function isTrueOrNull( $value, $message ) : FluidValidator;
public function isFalse( $value, $message ) : FluidValidator;
public function isFalseOrNull( $value, $message ) : FluidValidator;
```

## Conditional methods

```php
public function checkIf( $expression, $continue = 1 ) : FluidValidator;
public function ifIsString( $value, $continue = 1 ) : FluidValidator;
public function ifIsStringOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsNonEmptyString( $value, $continue = 1 ) : FluidValidator;
public function ifIsNonEmptyStringOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsNotEmpty( $value, $continue = 1 ) : FluidValidator;
public function ifIsNotEmptyOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsArray( $value, $continue = 1 ) : FluidValidator;
public function ifIsArrayOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsInt( $value, $continue = 1 ) : FluidValidator;
public function ifIsIntOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsIntInRange( $value, array $range, $continue = 1 ) : FluidValidator;
public function ifIsIntInRangeOrNull( $value, array $range, $continue = 1 ) : FluidValidator;
public function ifIsOneStringOf( $value, array $list, $continue = 1 ) : FluidValidator;
public function ifIsOneStringOfOrNull( $value, array $list, $continue = 1 ) : FluidValidator;
public function ifIsSubsetOf( $values, array $list, $continue = 1 ) : FluidValidator;
public function ifIsSubsetOfOrNull( $values, array $list, $continue = 1 ) : FluidValidator;
public function ifIsUuid( $value, $continue = 1 ) : FluidValidator;
public function ifIsUuidOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsEqual( $value1, $value2, $continue = 1 ) : FluidValidator;
public function ifIsNotEqual( $value1, $value2, $continue = 1 ) : FluidValidator;
public function ifIsSame( $value1, $value2, $continue = 1 ) : FluidValidator;
public function ifIsNotSame( $value1, $value2, $continue = 1 ) : FluidValidator;
public function ifIsNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsNotNull( $value, $continue = 1 ) : FluidValidator;
public function ifMatchesRegex( $value, $regex, $continue = 1 ) : FluidValidator;
public function ifMatchesRegexOrNull( $value, $regex, $continue = 1 ) : FluidValidator;
public function ifHasLength( $value, $length, $continue = 1 ) : FluidValidator;
public function ifHasLengthOrNull( $value, $length, $continue = 1 ) : FluidValidator;
public function ifHasMinLength( $value, $minLength, $continue = 1 ) : FluidValidator;
public function ifHasMinLengthOrNull( $value, $minLength, $continue = 1 ) : FluidValidator;
public function ifHasMaxLength( $value, $maxLength, $continue = 1 ) : FluidValidator;
public function ifHasMaxLengthOrNull( $value, $maxLength, $continue = 1 ) : FluidValidator;
public function ifCounts( $values, $count, $continue = 1 ) : FluidValidator;
public function ifCountsOrNull( $values, $count, $continue = 1 ) : FluidValidator;
public function ifIsEmail( $value, $continue = 1 ) : FluidValidator;
public function ifIsEmailOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsUrl( $value, $continue = 1 ) : FluidValidator;
public function ifIsUrlNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsJson( $value, $continue = 1 ) : FluidValidator;
public function ifIsJsonOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifHasKey( $values, $key, $continue = 1 ) : FluidValidator;
public function ifHasKeyOrNull( $values, $key, $continue = 1 ) : FluidValidator;
public function ifIsDate( $dateString, $format = 'Y-m-d', $continue = 1 ) : FluidValidator;
public function ifIsDateOrNull( $dateString, $format = 'Y-m-d', $continue = 1 ) : FluidValidator;
public function ifIsTrue( $value, $continue = 1 ) : FluidValidator;
public function ifIsTrueOrNull( $value, $continue = 1 ) : FluidValidator;
public function ifIsFalse( $value, $continue = 1 ) : FluidValidator;
public function ifIsFalseOrNull( $value, $continue = 1 ) : FluidValidator;
```

## Non-validation methods

```php
# Resets the validator to its initial state
public function reset() : FluidValidator;

# Returns TRUE, if all validations have passed, otherwise FALSE
public function passed() : bool;

# Returns TRUE, if one or more validations have failed, otherwise FALSE
public function failed() : bool;

# Returns the the value for $var from data provider, or $var if no data provider is set.
public function getValue( $var ) : mixed;

# Returns an array of messages collected from failed validations
public function getMessages() : array;
```

## Available validation modes

```php
# Processes all validations regardless of failed ones
CheckMode::CONTINUOUS

# Processes all validations until the first one failed
CheckMode::STOP_ON_FIRST_FAIL
```

## Basic usage

```php
<?php

namespace My\NS;

use hollodotme\FluidValidator\CheckMode;
use hollodotme\FluidValidator\FluidValidator;

$stringValue       = 'test';
$arrayValue        = [ 'test', 'test2' ];
$invalidEmail      = 'email@example@example.com';
$optionalBirthdate = null;

$validator = new FluidValidator( CheckMode::CONTINUOUS );

$validator->isNonEmptyString( $stringValue, 'This is not a string' )
          ->isArray( $arrayValue, 'Not an array' )
          ->isOneStringOf( $stringValue, $arrayValue, 'Is not part of the array' )
          ->isEmail( $invalidEmail, 'This email address is invalid' )
          ->isDateOrNull( $optionalBirthdate, 'Y-m-d', 'Birthdate is invalid' );

if ( $validator->failed() )
{
	print_r( $validator->getMessages() );
}
```

Prints:

```
Array
(
    [0] => This email address is invalid
)
```

## Advanced usage with data provider

If you have an object covering a data structure like an array or something like that, e.g. a request object, 
you can tell the `FluidValidator` to use this object to retrieve the values to validate from it.

All you need to do is to implement the `hollodotme\FluidValidator\Interfaces\ProvidesValuesToValidate` 
interface' method `getValueToValidate( $key )`.

```php
<?php

namespace My\NS;

use hollodotme\FluidValidator\FluidValidator;
use hollodotme\FluidValidator\CheckMode;
use hollodotme\FluidValidator\Interfaces\ProvidesValuesToValidate;

class Request implements ProvidesValuesToValidate
{
	/** @var array */
	private $requestData;

	/**
	 * @param array $requestData
	 */
	public function __construct( array $requestData )
	{
		$this->requestData = $requestData;
	}

	/*

	... some accessor methods

	*/

	/**
	 * Implements the ProvidesValuesToValidate interface
	 *
	 * @param mixed $key
	 *
	 * @return mixed|null
	 */
	public function getValueToValidate( $key )
	{
		return isset($this->requestData[ $key ]) ? $this->requestData[ $key ] : null;
	}
}

$requestData = [
	'name'      => 'Your Name',
	'language'  => 'de',
	'email'     => 'email@example@example.com',
	'birthdate' => '1980-01-01',
];

$request   = new Request( $requestData );
$validator = new FluidValidator( CheckMode::CONTINUOUS, $request );

$validator->isNonEmptyString( 'name', 'Name is empty.' )
          ->isOneStringOf( 'language', [ 'de', 'en' ], 'Invalid language.' )
          ->isEmail( 'email', 'This email address is invalid' )
          ->isDateOrNull( 'birthdate', 'Y-m-d', 'Birthdate is invalid' );

if ( $validator->failed() )
{
	print_r( $validator->getMessages() );
}
```


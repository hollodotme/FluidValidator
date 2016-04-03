[![Build Status](https://travis-ci.org/hollodotme/FluidValidator.svg?branch=master)](https://travis-ci.org/hollodotme/FluidValidator)
[![Coverage Status](https://coveralls.io/repos/hollodotme/FluidValidator/badge.svg?branch=master&service=github)](https://coveralls.io/github/hollodotme/FluidValidator?branch=master)
[![Latest Stable Version](https://poser.pugx.org/hollodotme/fluid-validator/v/stable)](https://packagist.org/packages/hollodotme/fluid-validator) 
[![Total Downloads](https://poser.pugx.org/hollodotme/fluid-validator/downloads)](https://packagist.org/packages/hollodotme/fluid-validator) 
[![Latest Unstable Version](https://poser.pugx.org/hollodotme/fluid-validator/v/unstable)](https://packagist.org/packages/hollodotme/fluid-validator) 
[![License](https://poser.pugx.org/hollodotme/fluid-validator/license)](https://packagist.org/packages/hollodotme/fluid-validator)

# FluidValidator

Validating data with a fluent interfaced class

**[Read more about this approach on my blog post.](http://bit.ly/FluValEn)**

## Requirements

* PHP >= 5.5
* [intl extension](http://php.net/manual/en/book.intl.php)

## Installation

```
composer require "hollodotme/fluid-validator" "~1.4.0"
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

Alvailable since version `1.1.0`:

```php
public function checkIf( $expression, $continue ) : FluidValidator;
public function ifIsString( $value, $continue ) : FluidValidator;
public function ifIsStringOrNull( $value, $continue ) : FluidValidator;
public function ifIsNonEmptyString( $value, $continue ) : FluidValidator;
public function ifIsNonEmptyStringOrNull( $value, $continue ) : FluidValidator;
public function ifIsNotEmpty( $value, $continue ) : FluidValidator;
public function ifIsNotEmptyOrNull( $value, $continue ) : FluidValidator;
public function ifIsArray( $value, $continue ) : FluidValidator;
public function ifIsArrayOrNull( $value, $continue ) : FluidValidator;
public function ifIsInt( $value, $continue ) : FluidValidator;
public function ifIsIntOrNull( $value, $continue ) : FluidValidator;
public function ifIsIntInRange( $value, array $range, $continue ) : FluidValidator;
public function ifIsIntInRangeOrNull( $value, array $range, $continue ) : FluidValidator;
public function ifIsOneStringOf( $value, array $list, $continue ) : FluidValidator;
public function ifIsOneStringOfOrNull( $value, array $list, $continue ) : FluidValidator;
public function ifIsSubsetOf( $values, array $list, $continue ) : FluidValidator;
public function ifIsSubsetOfOrNull( $values, array $list, $continue ) : FluidValidator;
public function ifIsUuid( $value, $continue ) : FluidValidator;
public function ifIsUuidOrNull( $value, $continue ) : FluidValidator;
public function ifIsEqual( $value1, $value2, $continue ) : FluidValidator;
public function ifIsNotEqual( $value1, $value2, $continue ) : FluidValidator;
public function ifIsSame( $value1, $value2, $continue ) : FluidValidator;
public function ifIsNotSame( $value1, $value2, $continue ) : FluidValidator;
public function ifIsNull( $value, $continue ) : FluidValidator;
public function ifIsNotNull( $value, $continue ) : FluidValidator;
public function ifMatchesRegex( $value, $regex, $continue ) : FluidValidator;
public function ifMatchesRegexOrNull( $value, $regex, $continue ) : FluidValidator;
public function ifHasLength( $value, $length, $continue ) : FluidValidator;
public function ifHasLengthOrNull( $value, $length, $continue ) : FluidValidator;
public function ifHasMinLength( $value, $minLength, $continue ) : FluidValidator;
public function ifHasMinLengthOrNull( $value, $minLength, $continue ) : FluidValidator;
public function ifHasMaxLength( $value, $maxLength, $continue ) : FluidValidator;
public function ifHasMaxLengthOrNull( $value, $maxLength, $continue ) : FluidValidator;
public function ifCounts( $values, $count, $continue ) : FluidValidator;
public function ifCountsOrNull( $values, $count, $continue ) : FluidValidator;
public function ifIsEmail( $value, $continue ) : FluidValidator;
public function ifIsEmailOrNull( $value, $continue ) : FluidValidator;
public function ifIsUrl( $value, $continue ) : FluidValidator;
public function ifIsUrlNull( $value, $continue ) : FluidValidator;
public function ifIsJson( $value, $continue ) : FluidValidator;
public function ifIsJsonOrNull( $value, $continue ) : FluidValidator;
public function ifHasKey( $values, $key, $continue ) : FluidValidator;
public function ifHasKeyOrNull( $values, $key, $continue ) : FluidValidator;
public function ifIsDate( $dateString, $format = 'Y-m-d', $continue ) : FluidValidator;
public function ifIsDateOrNull( $dateString, $format = 'Y-m-d', $continue ) : FluidValidator;
public function ifIsTrue( $value, $continue ) : FluidValidator;
public function ifIsTrueOrNull( $value, $continue ) : FluidValidator;
public function ifIsFalse( $value, $continue ) : FluidValidator;
public function ifIsFalseOrNull( $value, $continue ) : FluidValidator;
```

Available since version `1.3.0`:

```php
public function ifPassed( $continue ) : FluidValidator;
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

## Available message collectors

* `ScalarListMessageCollector` for collecting scalar message values (default, if none is provided)
* `GroupedListMessageCollector` for collecting scalar key / scalar value messages grouped by key

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

## Conditional skip of checks

Available since version `1.1.0`.

You often want to check a value only if a previous condition is true. 
Therefore the generic `checkIf` method was added, alongside with if-methods for each check method.
 
**Example:**

```php
<?php

namespace My\NS;

use hollodotme\FluidValidator\CheckMode;
use hollodotme\FluidValidator\FluidValidator;

$stringValue    = 'test';
$arrayValue     = [ 'test', 'test2' ];
$invalidEmail   = 'email@example@example.com';
$birthdate 		= 'not-a-date';

$validator = new FluidValidator( CheckMode::CONTINUOUS );

$validator->isNonEmptyString( $stringValue, 'This is not a string' )
          ->isArray( $arrayValue, 'Not an array' )
          ->isOneStringOf( $stringValue, $arrayValue, 'Is not part of the array' )
          # execute next 2 check methods, if $birthdate is a non-empty string
          # skip next 2 check methods otherwise
          ->ifIsNonEmptyString( $birthdate, 2 ) 
          ->isEqual( $birthdate, 'not-a-date', 'Is not equal' )
          ->isDate( $birthdate, 'Y-m-d', 'Birthdate is invalid' )
          ->isEmail( $invalidEmail, 'This email address is invalid' )
          # execute next 1 check method, if all previous checks passed so far
          # skip next 1 check method otherwise
          ->ifPassed( 1 )
          ->isNonEmptyString( '', 'String is empty' )
          ->isEqual( 'testing', $stringValue, 'Strings are not equal' );

if ( $validator->failed() )
{
	print_r( $validator->getMessages() );
}
```

**Prints:**

```
Array
(
    [0] => Birthdate is invalid
    [1] => This email address is invalid
    [2] => Strings are not equal
)
```

## Usage with data provider

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

## Usage with message collectors

Available since version `1.2.0`.

### ScalarListMessageCollector (default)

```php
<?php

namespace My\NS;

use hollodotme\FluidValidator\CheckMode;
use hollodotme\FluidValidator\FluidValidator;
use hollodotme\FluidValidator\MessageCollectors\ScalarListMessageCollector;

$stringValue       = 'test';
$arrayValue        = [ 'test', 'test2' ];
$invalidEmail      = 'email@example@example.com';
$optionalBirthdate = null;

$messageCollector = new ScalarListMessageCollector();
$validator        = new FluidValidator( CheckMode::CONTINUOUS, null, $messageCollector );

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

**Note:** Behaviour is the same as in the [basic usage](#basic-usage) example above.

### GroupedListMessageCollector

This collector expects messages to be an assoc. array with scalar keys and values.

```php
<?php

namespace My\NS;

use hollodotme\FluidValidator\CheckMode;
use hollodotme\FluidValidator\FluidValidator;
use hollodotme\FluidValidator\MessageCollectors\GroupedListMessageCollector;

$stringValue       = 'test';
$arrayValue        = [ 'test', 'test2' ];
$invalidEmail      = 'email@example@example.com';
$optionalBirthdate = null;

$messageCollector = new GroupedListMessageCollector();
$validator        = new FluidValidator( CheckMode::CONTINUOUS, null, $messageCollector );

$validator->isNonEmptyString( '', [ 'string' => 'String is empty' ] )
          ->isArray( '', [ 'list' => 'Not an array' ] )
          ->isOneStringOf( 'test3', $arrayValue, [ 'list' => 'Is not part of the array' ] )
          ->isEmail( $invalidEmail, [ 'email' => 'This email address is invalid' ] )
          ->isDate( $optionalBirthdate, 'Y-m-d', [ 'birthdate' => 'Birthdate is invalid' ] );

if ( $validator->failed() )
{
	print_r( $validator->getMessages() );
}
```

Prints:

```
Array
(
    [string] => Array (
    	[0] => This email address is invalid
    ),
    [list] => Array (
    	[0] => Not an array
    	[1] => Is not part of the array
    ),
    [email] => Array (
    	[0] => This email address is invalid
    ),
    [birthdate] => Array (
    	[0] => Birthdate is invalid
    )
)
```

**Note:**

* The "list" key is given twice, so 2 messages were grouped under this key. 
* The value for a group key is always an array with numeric keys

### Custom message collector implementations

For a custom implementation of a message collector, simply create a class that implements 
the `hollodotme\FluidValidator\Interfaces\CollectsMessages` interface.

```php
<?php

namespace My\NS;

use hollodotme\FluidValidator\Interfaces\CollectsMessages;

class MyMessageCollector implements CollectsMessages
{
	/** @var array */
	private $messages = [];

	/**
	 * @param mixed $message
	 *
	 * @return bool
	 */
	public function isMessageValid( $message )
	{
		// Check for a valid type or format of your expected messages
		// Example:
		
		return is_string( $message );
	}

	/**
	 * @param mixed $message
	 */
	public function addMessage( $message )
	{
		// Add a message to your collection
		// Example:
		
		$this->messages[] = $message;
	}

	public function clearMessages()
	{
		// Clear the message list
		// Example:
		
		$this->messages = [];
	}

	/**
	 * @return array
	 */
	public function getMessages()
	{
		// Provide the collected messages
		// Example:
		
		return $this->messages;
	}
}
```

### Extending FluidValidator with own checks

Internally all validation and conditional methods are mapped to protected check methods returning a boolean.
`TRUE` if the check has passed, `FALSE` otherwise.

So extending FluidValidator is very simple.

#### 1. Extend the class and add a check method

Let's add a method that checks for a valid postal address.

```php
<?php

namespace My\NS;

use hollodotme\FluidValidator\FluidValidator;

class MyFluidValidator extends FluidValidator
{
	/**
	 * @param string $street
	 * @param string $streetNumber
	 * @param string $zipCode
	 * @param string $city
	 *
	 * @return bool
	 */
	protected function checkIsPostalAddress( $street, $streetNumber, $zipCode, $city )
	{
		$validPostalAddress = true;
		
		# Simple formal checks first
		# You can use existing check methods here
		$validPostalAddress &= $this->checkIsNonEmptyString( $street );
		$validPostalAddress &= $this->checkMatchesRegex( $streetNumber, "#^[0-9a-z\- ]$#i" );
		$validPostalAddress &= $this->checkMatchesRegex( $zipCode, "#^[0-9]{5}$#" );
		$validPostalAddress &= $this->checkIsNonEmptyString( $city );
		
		if ( (bool)$validPostalAddress )
		{
			# Semantic check of postal address
		
			# Fetch real values, if a data provider is used...
			$streetValue 		= $this->getValue( $street );
			$streetNumberValue 	= $this->getValue( $streetNumber );
			$zipCodeValue 		= $this->getValue( $zipCode );
			$cityValue 			= $this->getValue( $city );
		
			# Assuming you have a postal address validator doing the semantic check
		
			$validator = new PostalAddressValidator( $street, $streetNumber, $zipCode, $city );
		
			$validPostalAddress = $validator->isValid();
		}
		
		return (bool)$validPostalAddress;
	}
}
```

#### 2. Use it for validation / conditions

Now you're able to use this as a validation method with an additional message parameter 
and as a conditional method with an additional continue parameter:

```php
<?php

$myFluidValidator = new MyFluidValidator();

# As validation method
$myFluidValidator->isPostalAddress(
	'MyStreet', '123 a', '01234', 'MyCity',
	'Address is not valid'
);

# As conditional method
$myFluidValidator->ifIsPostalAddress(
	'MyStreet', '123 a', '01234', 'MyCity',
	3
);
/** Skip next 3 methods, if it is not a valid postal address **/
```

#### 3. Add method signatures

To have better auto completion in your IDE, add the relevant method signatures
to the head phpdoc of your class.

```php
<?php

namespace My\NS;

use hollodotme\FluidValidator\FluidValidator;

/**
 * Class MyFluidValidator
 * @package My\NS;
 * METHODSTART
 * @method MyFluidValidator isPostalAddress($street, $streetNumber, $zipCode, $city, $message)
 * @method MyFluidValidator ifIsPostalAddress($street, $streetNumber, $zipCode, $city, $continue)
 * METHODEND
 */
class MyFluidValidator extends FluidValidator
{
    /* ... */
}
```

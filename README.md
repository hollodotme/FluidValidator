# FluidValidator

Validating values with a fluid interfaced class

## Basic usage

```php
<?php

namespace My\Namespace;

use hollodotme\FluidValidator\FluidValidator;
use hollodotme\FluidValidator\CheckMode;

$stringValue = 'test';
$arrayValue = [ 'test', 'test2' ];

$validator = new FluidValidator( CheckMode::ALL );

$validator->isNonEmptyString( $stringValue, 'This is not a string' )
	->isArray( $arrayValue )
	->isOneStringOf( $stringValue, $arrayValue, 'Is not part of the array' );
	
if (!$validator->getBoolResult)
{
	print_r( $validator->getMessages() );
}
```



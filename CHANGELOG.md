# CHANGELOG

## Changes in Version 1.3.1

* Fixed issue #1

## Changes in Version 1.3.0

* Introduced `ifPassed( $continue )` method for a conditional continue of x further checks, only if all previous checks passed so far.

See [README](./README.md#conditional-skip-of-checks) for an example.

## Changes in Version 1.2.0

* Added support for custom message collecting by introducing the `CollectsMessage` interface 
and a third contructor parameter

```php
<?php
/**
	 * @param int                           $mode
	 * @param ProvidesValuesToValidate|null $dataProvider
	 * @param CollectsMessages              $messageCollector
	 */
	public function __construct(
		$mode = CheckMode::CONTINUOUS,
		ProvidesValuesToValidate $dataProvider = null,
		CollectsMessages $messageCollector = null
	)
```

* Added 2 ready to use message collectors:
  * `ScalarListMessageCollector` for collecting scalar message values (default, if none is provided)
  * `GroupedListMessageCollector` for collecting scalar key / scalar value messages grouped by key

See [README](./README.md#usage-with-message-collectors) for an example.

### Backward incompatibility changes

* Changed modifier of `$passed` member from `protected` to `private` in `FluidValidator`.
* Replaced `protected $messages` by `private $messageCollector` in `FluidValidator`.

**Hint:** Both changes only affect extending classes. 
The behaviour of `FluidValidator` was left unchanged. 

## Changes in version 1.1.0

* Added strict bool check methods `isTrue` / `isFalse` and `isTrueOrNull` / `isFalseOrNull`
* Added `checkIf` method to conditionally skip a number of following check methods
* Added a `if...` method for each check method to make the check result a condition
* Changed modifier of `getValue` from `protected` to `public` to give direct access to values from a data provider

See [README](./README.md) for a full method list and details.
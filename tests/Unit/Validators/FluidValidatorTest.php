<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Tests\Unit\Validators;

use hollodotme\FluidValidator\CheckMode;
use hollodotme\FluidValidator\Exceptions\CheckMethodNotCallable;
use hollodotme\FluidValidator\FluidValidator;
use hollodotme\FluidValidator\Interfaces\ProvidesValuesToValidate;
use hollodotme\FluidValidator\MessageCollectors\GroupedListMessageCollector;
use hollodotme\FluidValidator\Tests\Unit\Fixtures\ValueObjects;

class FluidValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function testInitialStatus()
	{
		$validator = new FluidValidator();

		$this->assertTrue( $validator->passed() );
		$this->assertFalse( $validator->failed() );
		$this->assertEmpty( $validator->getMessages() );
		$this->assertInternalType( 'array', $validator->getMessages() );
	}

	public function testStatusAfterResetIsSameAsInitialStatus()
	{
		$validator = new FluidValidator();

		$this->assertFalse( $validator->isString( null, 'TestMessage' )->passed() );
		$this->assertEquals( [ 'TestMessage' ], $validator->getMessages() );

		$this->assertFalse( $validator->passed() );
		$this->assertTrue( $validator->failed() );
		$this->assertNotEmpty( $validator->getMessages() );
		$this->assertInternalType( 'array', $validator->getMessages() );

		$validator->reset();

		$this->assertTrue( $validator->passed() );
		$this->assertFalse( $validator->failed() );
		$this->assertEmpty( $validator->getMessages() );
		$this->assertInternalType( 'array', $validator->getMessages() );
	}

	public function testCanCallMethodsWithSuffixOrNull()
	{
		$validator = new FluidValidator();

		$this->assertFalse( $validator->isString( null, 'TestMessage' )->passed() );
		$this->assertEquals( [ 'TestMessage' ], $validator->getMessages() );

		$validator->reset();

		$this->assertTrue( $validator->isStringOrNull( null, 'TestMessage' )->passed() );
		$this->assertFalse( $validator->isStringOrNull( null, 'TestMessage' )->failed() );
		$this->assertEquals( [ ], $validator->getMessages() );
	}

	/**
	 * @param string $unknownMethod
	 *
	 * @dataProvider unknownMethodProvider
	 * @expectedException \hollodotme\FluidValidator\Exceptions\CheckMethodNotCallable
	 */
	public function testCallingUnknownMethodFails( $unknownMethod )
	{
		$validator = new FluidValidator();
		$validator->{$unknownMethod}( null, 'TestMessage' );
	}

	public function unknownMethodProvider()
	{
		return [
			[ 'OrNull' ],
			[ 'orNull' ],
			[ 'unknownMethod' ],
			[ 'isStringOrNullString' ],
		];
	}

	public function testRecordingMessagesStopsAfterFirstFailedValidationInStopOnFirstFailMode()
	{
		$validator = new FluidValidator( CheckMode::STOP_ON_FIRST_FAIL );
		$validator->isString( 'Yes', 'Succeeds' )
		          ->isString( null, 'First fail' )
		          ->isString( null, 'Second fail' )
		          ->isString( 'Yes', 'Succeeds' );

		$this->assertFalse( $validator->passed() );
		$this->assertTrue( $validator->failed() );
		$this->assertEquals( [ 'First fail' ], $validator->getMessages() );
	}

	public function testRecordingMessagesContinuesAfterFirstFailedValidationInCheckAllMode()
	{
		$validator = new FluidValidator( CheckMode::CONTINUOUS );
		$validator->isString( 'Yes', 'Succeeds' )
		          ->isString( null, 'First fail' )
		          ->isString( null, 'Second fail' )
		          ->isString( 'Yes', 'Succeeds' )
		          ->isString( null, 'Third fail' );

		$this->assertFalse( $validator->passed() );
		$this->assertTrue( $validator->failed() );
		$this->assertEquals( [ 'First fail', 'Second fail', 'Third fail' ], $validator->getMessages() );
	}

	/**
	 * @dataProvider isNonEmptyStringProvider
	 *
	 * @param mixed  $value
	 * @param bool   $expectedBool
	 * @param string $expectedMessage
	 */
	public function testIsNonEmptyString( $value, $expectedBool, $expectedMessage )
	{
		$validator = new FluidValidator();
		$validator->isNonEmptyString( $value, 'String is empty' );

		$this->assertSame( $expectedBool, $validator->passed() );
		$this->assertEquals( $expectedMessage, $validator->getMessages() );
	}

	/**
	 * @return array
	 */
	public function isNonEmptyStringProvider()
	{
		return [
			[ '', false, [ 'String is empty' ] ],
			[ ' ', false, [ 'String is empty' ] ],
			[ "\n", false, [ 'String is empty' ] ],
			[ "\r", false, [ 'String is empty' ] ],
			[ "\t", false, [ 'String is empty' ] ],
			[ "\x0B", false, [ 'String is empty' ] ],
			[ "\0", false, [ 'String is empty' ] ],
			[ "Unit-Test", true, [ ] ],
			[ "1", true, [ ] ],
			[ "0", true, [ ] ],
			[ "null", true, [ ] ],
			[ "1.23", true, [ ] ],
			[ 12, true, [ ] ],
			[ 12.3, true, [ ] ],
			[ new ValueObjects\ObjectWithToStringMethod( '' ), false, [ 'String is empty' ] ],
			[ new ValueObjects\ObjectWithToStringMethod( 'Unit-Test' ), true, [ ] ],
			[ new ValueObjects\ObjectWithoutToStringMethod( 'Unit-Test' ), false, [ 'String is empty' ] ],
			[ new \stdClass(), false, [ 'String is empty' ] ],
			[ false, false, [ 'String is empty' ] ],
			[ true, false, [ 'String is empty' ] ],
			[ null, false, [ 'String is empty' ] ],
		];
	}

	/**
	 * @dataProvider isNotEmptyProvider
	 *
	 * @param mixed  $value
	 * @param bool   $expectedBool
	 * @param string $expectedMessage
	 */
	public function testIsNotEmpty( $value, $expectedBool, $expectedMessage )
	{
		$validator = new FluidValidator();
		$validator->isNotEmpty( $value, 'Is empty' );

		$this->assertSame( $expectedBool, $validator->passed() );
		$this->assertEquals( $expectedMessage, $validator->getMessages() );
	}

	/**
	 * @return array
	 */
	public function isNotEmptyProvider()
	{
		return [
			[ ' ', true, [ ] ],
			[ 'Unit', true, [ ] ],
			[ 123, true, [ ] ],
			[ 0, false, [ 'Is empty' ] ],
			[ '', false, [ 'Is empty' ] ],
			[ [ ], false, [ 'Is empty' ] ],
			[ 0.0, false, [ 'Is empty' ] ],
			[ null, false, [ 'Is empty' ] ],
			[ false, false, [ 'Is empty' ] ],
			[ true, true, [ ] ],
			[ 12.3, true, [ ] ],
		];
	}

	/**
	 * @dataProvider isArrayProvider
	 *
	 * @param mixed  $value
	 * @param bool   $expectedBool
	 * @param string $expectedMessage
	 */
	public function testIsArray( $value, $expectedBool, $expectedMessage )
	{
		$validator = new FluidValidator();
		$validator->isArray( $value, 'Not an array' );

		$this->assertSame( $expectedBool, $validator->passed() );
		$this->assertEquals( $expectedMessage, $validator->getMessages() );
	}

	/**
	 * @return array
	 */
	public function isArrayProvider()
	{
		return [
			[ [ ], true, [ ] ],
			[ [ 'Unit', 'Test' ], true, [ ] ],
			[ [ 'Unit', [ 'Test' ] ], true, [ ] ],
			[ 'Unit,Test', false, [ 'Not an array' ] ],
			[ new \stdClass(), false, [ 'Not an array' ] ],
			[ 1, false, [ 'Not an array' ] ],
			[ null, false, [ 'Not an array' ] ],
			[ false, false, [ 'Not an array' ] ],
			[ true, false, [ 'Not an array' ] ],
			[ 0, false, [ 'Not an array' ] ],
		];
	}

	/**
	 * @dataProvider isIntProvider
	 *
	 * @param mixed  $value
	 * @param bool   $expectedBool
	 * @param string $expectedMessage
	 */
	public function testIsInt( $value, $expectedBool, $expectedMessage )
	{
		$validator = new FluidValidator();
		$validator->isInt( $value, 'Not an int' );

		$this->assertSame( $expectedBool, $validator->passed() );
		$this->assertEquals( $expectedMessage, $validator->getMessages() );
	}

	/**
	 * @return array
	 */
	public function isIntProvider()
	{
		return [
			[ false, false, [ 'Not an int' ] ],
			[ true, false, [ 'Not an int' ] ],
			[ null, false, [ 'Not an int' ] ],
			[ 0, true, [ ] ],
			[ 1, true, [ ] ],
			[ -1, true, [ ] ],
			[ '-1', true, [ ] ],
			[ '0', true, [ ] ],
			[ '1', true, [ ] ],
			[ '13232345546548785456464121515454', false, [ 'Not an int' ] ],
			[ 13232345546548785456464121515454, false, [ 'Not an int' ] ],
			[ '12.3', false, [ 'Not an int' ] ],
			[ 12.3, false, [ 'Not an int' ] ],
			[ new \stdClass(), false, [ 'Not an int' ] ],
			[ new ValueObjects\ObjectWithToStringMethod( '' ), false, [ 'Not an int' ] ],
			[ new ValueObjects\ObjectWithToStringMethod( '12345' ), true, [ ] ],
			[ new ValueObjects\ObjectWithoutToStringMethod( '12345' ), false, [ 'Not an int' ] ],
		];
	}

	/**
	 * @dataProvider isIntInRangeProvider
	 *
	 * @param mixed  $value
	 * @param array  $list
	 * @param bool   $expectedBool
	 * @param string $expectedMessage
	 */
	public function testIsIntInRange( $value, array $list, $expectedBool, $expectedMessage )
	{
		$validator = new FluidValidator();
		$validator->isIntInRange( $value, $list, 'Not in range' );

		$this->assertSame( $expectedBool, $validator->passed() );
		$this->assertEquals( $expectedMessage, $validator->getMessages() );
	}

	/**
	 * @return array
	 */
	public function isIntInRangeProvider()
	{
		return [
			[ 0, range( -5, +5 ), true, [ ] ],
			[ 5, range( -5, +5 ), true, [ ] ],
			[ -5, range( -5, +5 ), true, [ ] ],
			[ -6, range( -5, +5 ), false, [ 'Not in range' ] ],
			[ 6, range( -5, +5 ), false, [ 'Not in range' ] ],
			[ '0', range( -5, +5 ), true, [ ] ],
			[ '5', range( -5, +5 ), true, [ ] ],
			[ '-5', range( -5, +5 ), true, [ ] ],
			[ '-6', range( -5, +5 ), false, [ 'Not in range' ] ],
			[ '6', range( -5, +5 ), false, [ 'Not in range' ] ],
			[ false, range( -5, +5 ), false, [ 'Not in range' ] ],
			[ true, range( -5, +5 ), false, [ 'Not in range' ] ],
			[ null, range( -5, +5 ), false, [ 'Not in range' ] ],
			[ new \stdClass(), range( -5, +5 ), false, [ 'Not in range' ] ],
			[ new ValueObjects\ObjectWithoutToStringMethod( '5' ), range( -5, +5 ), false, [ 'Not in range' ] ],
			[ new ValueObjects\ObjectWithToStringMethod( '3' ), range( -5, +5 ), true, [ ] ],
		];
	}

	/**
	 * @dataProvider isOneStringOfProvider
	 *
	 * @param mixed  $value
	 * @param array  $list
	 * @param bool   $expectedBool
	 * @param string $expectedMessage
	 */
	public function testIsOneStringOf( $value, array $list, $expectedBool, $expectedMessage )
	{
		$validator = new FluidValidator();
		$validator->isOneStringOf( $value, $list, 'Not a string of' );

		$this->assertSame( $expectedBool, $validator->passed() );
		$this->assertEquals( $expectedMessage, $validator->getMessages() );
	}

	/**
	 * @return array
	 */
	public function isOneStringOfProvider()
	{
		return [
			[ '', [ 'Yes', '', 'No' ], true, [ ] ],
			[ 'Yes', [ 'Yes', '', 'No' ], true, [ ] ],
			[ 'No', [ 'Yes', '', 'No' ], true, [ ] ],
			[ 0, [ 'Yes', '', 'No' ], false, [ 'Not a string of' ] ],
			[ null, [ 'Yes', '', 'No' ], false, [ 'Not a string of' ] ],
			[ false, [ 'Yes', '', 'No' ], false, [ 'Not a string of' ] ],
			[ true, [ 'Yes', '', 'No' ], false, [ 'Not a string of' ] ],
			[ new \stdClass(), [ 'Yes', '', 'No' ], false, [ 'Not a string of' ] ],
			[
				new ValueObjects\ObjectWithoutToStringMethod( 'Yes' ), [ 'Yes', '', 'No' ], false,
				[ 'Not a string of' ],
			],
			[ new ValueObjects\ObjectWithToStringMethod( 'Yes' ), [ 'Yes', '', 'No' ], true, [ ] ],
		];
	}

	/**
	 * @dataProvider isSubsetOfProvider
	 *
	 * @param mixed  $values
	 * @param array  $list
	 * @param bool   $expectedBool
	 * @param string $expectedMessage
	 */
	public function testIsSubsetOf( $values, array $list, $expectedBool, $expectedMessage )
	{
		$validator = new FluidValidator();
		$validator->isSubsetOf( $values, $list, 'Not a subset' );

		$this->assertSame( $expectedBool, $validator->passed() );
		$this->assertEquals( $expectedMessage, $validator->getMessages() );
	}

	/**
	 * @return array
	 */
	public function isSubsetOfProvider()
	{
		return [
			[ [ '' ], [ 'Yes', '', 'No' ], true, [ ] ],
			[ [ 'Yes' ], [ 'Yes', '', 'No' ], true, [ ] ],
			[ [ 'No' ], [ 'Yes', '', 'No' ], true, [ ] ],
			[ [ 'No', '', 'Yes' ], [ 'Yes', '', 'No' ], true, [ ] ],
			[ [ 'No', 'Yes' ], [ 'Yes', '', 'No' ], true, [ ] ],
			[ [ 'No', '' ], [ 'Yes', '', 'No' ], true, [ ] ],
			[ [ 'Yes', '' ], [ 'Yes', '', 'No' ], true, [ ] ],
			[ [ 'Unit', 'Test' ], [ 'Yes', '', 'No' ], false, [ 'Not a subset' ] ],
			[ [ ], [ 'Yes', '', 'No' ], false, [ 'Not a subset' ] ],
			[ [ false, true, 0 ], [ 'Yes', '', 'No' ], false, [ 'Not a subset' ] ],
			[ 'Yes', [ 'Yes', '', 'No' ], false, [ 'Not a subset' ] ],
			[ new \stdClass(), [ 'Yes', '', 'No' ], false, [ 'Not a subset' ] ],
			[ null, [ 'Yes', '', 'No' ], false, [ 'Not a subset' ] ],
			[ false, [ 'Yes', '', 'No' ], false, [ 'Not a subset' ] ],
			[ true, [ 'Yes', '', 'No' ], false, [ 'Not a subset' ] ],
		];
	}

	/**
	 * @dataProvider isUuidProvider
	 *
	 * @param mixed  $value
	 * @param bool   $expectedBool
	 * @param string $expectedMessage
	 */
	public function testIsUuid( $value, $expectedBool, $expectedMessage )
	{
		$validator = new FluidValidator();
		$validator->isUuid( $value, 'Not a uuid' );

		$this->assertSame( $expectedBool, $validator->passed() );
		$this->assertEquals( $expectedMessage, $validator->getMessages() );
	}

	/**
	 * @return array
	 */
	public function isUuidProvider()
	{
		return [
			[ '00000000-0000-0000-0000-000000000000', true, [ ] ],
			[ '01a2b3c4-D5F6-7a8b-9c0D-1E2f3a4B5c6D', true, [ ] ],
			[ 'AAAAAAAA-BBBB-CCCC-DDDD-EEEEEEEEEEEE', true, [ ] ],
			[ '12345678-1234-5678-9101-121314151617', true, [ ] ],
			[ new ValueObjects\ObjectWithToStringMethod( '12345678-1234-5678-9101-121314151617' ), true, [ ] ],
			[
				new ValueObjects\ObjectWithoutToStringMethod( '12345678-1234-5678-9101-121314151617' ), false,
				[ 'Not a uuid' ],
			],
			[ 'GGGGGGGG-HHHH-IIII-JJJJ-KKKKKKKKKKKK', false, [ 'Not a uuid' ] ],
			[ 0, false, [ 'Not a uuid' ] ],
			[ 123, false, [ 'Not a uuid' ] ],
			[ '0', false, [ 'Not a uuid' ] ],
			[ false, false, [ 'Not a uuid' ] ],
			[ true, false, [ 'Not a uuid' ] ],
			[ null, false, [ 'Not a uuid' ] ],
			[ 12.3, false, [ 'Not a uuid' ] ],
		];
	}

	/**
	 * @param string $dateString
	 * @param string $format
	 * @param bool   $expectedResult
	 *
	 * @dataProvider isDateProvider
	 */
	public function testIsDate( $dateString, $format, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->isDate( $dateString, $format, 'Not a valid date string' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function isDateProvider()
	{
		return [
			# Invalid
			[ '2013-13-01', 'Y-m-d', false ],
			[ '20132-13-0', 'Y-m-d', false ],
			[ '2013-11-32', 'Y-m-d', false ],
			[ '2015-05-o1', 'Y-m-d', false ],
			[ 'I6.03.1984', 'd.m.Y', false ],
			[ '1970-01-01 25:59:59', 'Y-m-d H:i:s', false ],
			# Valid
			[ '2015-05-01', 'Y-m-d', true ],
			[ '2015-12-31', 'Y-m-d', true ],
			[ '2015-01-01', 'Y-m-d', true ],
			[ '16.03.1984', 'd.m.Y', true ],
			[ '1970-01-01 23:59:59', 'Y-m-d H:i:s', true ],
		];
	}

	/**
	 * @param mixed $value
	 * @param bool  $expectedResult
	 *
	 * @dataProvider isTrueDataProvider
	 */
	public function testIsTrue( $value, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->isTrue( $value, 'Not TRUE' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function isTrueDataProvider()
	{
		return [
			[ true, true ],
			[ false, false ],
			[ null, false ],
			[ 'TRUE', false ],
			[ 1, false ],
		];
	}

	/**
	 * @param mixed $value
	 * @param bool  $expectedResult
	 *
	 * @dataProvider isFalseDataProvider
	 */
	public function testIsFalse( $value, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->isFalse( $value, 'Not FALSE' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function isFalseDataProvider()
	{
		return [
			[ false, true ],
			[ true, false ],
			[ null, false ],
			[ 'FALSE', false ],
			[ 0, false ],
		];
	}

	/**
	 * @param mixed $value1
	 * @param mixed $value2
	 * @param bool  $expectedResult
	 *
	 * @dataProvider equalValuesProvider
	 */
	public function testCanCheckForEqualValues( $value1, $value2, $expectedResult )
	{
		$validator = new FluidValidator();
		$validator->isEqual( $value1, $value2, "Values are not equal." );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function equalValuesProvider()
	{
		return [
			# Not equal
			[ 'Unit', 'Test', false ],
			[ null, true, false ],

			# Equal
			[ 'Unit', 'Unit', true ],
			[ null, false, true ],
			[ 123, 123.0, true ],
			[ 'Test', new ValueObjects\ObjectWithToStringMethod( 'Test' ), true ],
		];
	}

	/**
	 * @param mixed $value1
	 * @param mixed $value2
	 * @param bool  $expectedResult
	 *
	 * @dataProvider notEqualValuesProvider
	 */
	public function testCanCheckForNotEqualValues( $value1, $value2, $expectedResult )
	{
		$validator = new FluidValidator();
		$validator->isNotEqual( $value1, $value2, "Values are not equal." );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function notEqualValuesProvider()
	{
		return [
			# Not not equal
			[ 'Unit', 'Test', true ],
			[ null, true, true ],

			# not Equal
			[ 'Unit', 'Unit', false ],
			[ null, false, false ],
			[ 123, 123.0, false ],
			[ 'Test', new ValueObjects\ObjectWithToStringMethod( 'Test' ), false ],
		];
	}

	/**
	 * @param mixed $value1
	 * @param mixed $value2
	 * @param bool  $expectedResult
	 *
	 * @dataProvider sameValuesProvider
	 */
	public function testCanCheckForSameValues( $value1, $value2, $expectedResult )
	{
		$validator = new FluidValidator();
		$validator->isSame( $value1, $value2, "Values are not the same." );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function sameValuesProvider()
	{
		$stringObject = new ValueObjects\ObjectWithToStringMethod( 'Test' );

		return [
			# Not equal
			[ 123, 123.0, false ],
			[ null, false, false ],
			[ 'Test', new ValueObjects\ObjectWithToStringMethod( 'Test' ), false ],
			[
				new ValueObjects\ObjectWithToStringMethod( 'Test' ),
				new ValueObjects\ObjectWithToStringMethod( 'Test' ),
				false,
			],

			# Equal
			[ 'Unit', 'Unit', true ],
			[ null, null, true ],
			[ false, false, true ],
			[ true, true, true ],
			[ 123, 123, true ],
			[ 456.7, 456.7, true ],
			[ $stringObject, $stringObject, true ],
		];
	}

	/**
	 * @param mixed $value1
	 * @param mixed $value2
	 * @param bool  $expectedResult
	 *
	 * @dataProvider notSameValuesProvider
	 */
	public function testCanCheckForNotSameValues( $value1, $value2, $expectedResult )
	{
		$validator = new FluidValidator();
		$validator->isNotSame( $value1, $value2, "Values are not the same." );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function notSameValuesProvider()
	{
		$stringObject = new ValueObjects\ObjectWithToStringMethod( 'Test' );

		return [
			# Not not same
			[ 123, 123.0, true ],
			[ null, false, true ],
			[ 'Test', new ValueObjects\ObjectWithToStringMethod( 'Test' ), true ],
			[
				new ValueObjects\ObjectWithToStringMethod( 'Test' ),
				new ValueObjects\ObjectWithToStringMethod( 'Test' ),
				true,
			],

			# Not same
			[ 'Unit', 'Unit', false ],
			[ null, null, false ],
			[ false, false, false ],
			[ true, true, false ],
			[ 123, 123, false ],
			[ 456.7, 456.7, false ],
			[ $stringObject, $stringObject, false ],
		];
	}

	public function testCanCheckValueIsNull()
	{
		$validator = new FluidValidator();

		$validator->isNull( null, 'Value is not null' );

		$this->assertTrue( $validator->passed() );
	}

	public function testCanCheckValueIsNotNull()
	{
		$validator = new FluidValidator();

		$validator->isNotNull( false, 'Value is null' );

		$this->assertTrue( $validator->passed() );
	}

	/**
	 * @param string $value
	 * @param string $regex
	 * @param bool   $expectedResult
	 *
	 * @dataProvider regexMatchProvider
	 */
	public function testCanCheckValueMatchesRegex( $value, $regex, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->matchesRegex( $value, $regex, 'Value does not match regex.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function regexMatchProvider()
	{
		return [
			# Matches
			[ 'Unit', "#^Unit$#", true ],
			[ 'Test', "#es#", true ],

			# Matches not
			[ 'Unit', "#^unit$#", false ],
			[ 'Test', "#te#", false ],
			[ null, "#something#", false ],
		];
	}

	/**
	 * @param string $value
	 * @param int    $length
	 * @param bool   $expectedResult
	 *
	 * @dataProvider lengthProvider
	 */
	public function testCanCheckValueHasLength( $value, $length, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->hasLength( $value, $length, 'Value has not correct length.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function lengthProvider()
	{
		return [
			# Has length
			[ 'Unit', 4, true ],
			[ 'Unit-Test', 9, true ],
			[ 123, 3, true ],
			[ 'åèö', 6, true ],

			# Has not length
			[ 'Unit', 3, false ],
			[ 123, 4, false ],
			[ null, 1, false ],
		];
	}

	/**
	 * @param string $value
	 * @param int    $minLength
	 * @param bool   $expectedResult
	 *
	 * @dataProvider minLengthProvider
	 */
	public function testCanCheckValueHasMinLength( $value, $minLength, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->hasMinLength( $value, $minLength, 'Value has not min length.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function minLengthProvider()
	{
		return [
			# Has min length
			[ 'Unit', 3, true ],
			[ 'Test', 2, true ],
			[ 'Unit-Test', 9, true ],
			[ 'mœrely', 7, true ],
			[ 1234, 3, true ],

			# Has not min length
			[ 'Unit', 5, false ],
			[ 'Test', 6, false ],
			[ 'Unit-Test', 11, false ],
			[ 1234, 5, false ],
			[ null, 3, false ],
			[ new \stdClass(), 5, false ],
		];
	}

	/**
	 * @param string $value
	 * @param int    $maxLength
	 * @param bool   $expectedResult
	 *
	 * @dataProvider maxLengthProvider
	 */
	public function testCanCheckValueHasMaxLength( $value, $maxLength, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->hasMaxLength( $value, $maxLength, 'Value has not max length.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function maxLengthProvider()
	{
		return [
			# Has max length
			[ 'Unit', 5, true ],
			[ 'Test', 4, true ],
			[ 'Unit-Test', 10, true ],
			[ 'åèö', 6, true ],
			[ 123, 3, true ],

			# Has not max length
			[ 'Unit', 3, false ],
			[ 'Test', 2, false ],
			[ 'Unit-Test', 8, false ],
			[ 'åèö', 5, false ],
			[ 123.1, 4, false ],
			[ null, 4, false ],
			[ new \stdClass(), 8, false ],
		];
	}

	/**
	 * @param mixed $value
	 * @param int   $count
	 * @param bool  $expectedResult
	 *
	 * @dataProvider arrayCountProvider
	 */
	public function testCanCheckArrayCounts( $value, $count, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->counts( $value, $count, 'Count is not correct.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function arrayCountProvider()
	{
		return [
			# Count matches
			[ [ 'Unit', 'Test' ], 2, true ],
			[ [ ], 0, true ],
			[ [ null, false, true ], 3, true ],

			# Count matches not
			[ 'no array', 1, false ],
			[ [ 'Unit', 'Test' ], 3, false ],
			[ null, 1, false ],
		];
	}

	/**
	 * @param string $value
	 * @param bool   $expectedResult
	 *
	 * @dataProvider emailProvider
	 */
	public function testCanCheckValueIsEmailAddress( $value, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->isEmail( $value, 'Not an email address.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function emailProvider()
	{
		return [
			# Valid email addresses
			[ 'email@example.com', true ],
			[ 'firstname.lastname@example.com', true ],
			[ 'email@subdomain.example.com', true ],
			[ 'firstname+lastname@example.com', true ],
			[ 'email@[123.123.123.123]', true ],
			[ '"email"@example.com', true ],
			[ '1234567890@example.com', true ],
			[ 'email@example-one.com', true ],
			[ '_______@example.com', true ],
			[ 'email@example.name', true ],
			[ 'email@example.museum', true ],
			[ 'email@example.co.jp', true ],
			[ 'firstname-lastname@example.com', true ],
			[ new ValueObjects\ObjectWithToStringMethod( 'me@example.com' ), true ],

			# Invalid email addresses
			[ '#@%^%#$@#$@#.com', false ],
			[ '@example.com', false ],
			[ 'Joe Smith <email@example.com>', false ],
			[ '                email.example.com', false ],
			[ 'email@example@example.com', false ],
			[ '             .email@example.com', false ],
			[ 'email.@example.com', false ],
			[ 'email..email@example.com', false ],
			[ 'あいうえお@example.com', false ],
			[ 'email@example.com (Joe Smith)', false ],
			[ 'email@example', false ],
			[ 'email@-example.com', false ],
			[ 'email@111.222.333.44444', false ],
			[ 'email@example..com', false ],
			[ 'Abc..123@example.com', false ],
			[ null, false ],
			[ true, false ],
			[ false, false ],
			[ 123, false ],
			[ 123.1, false ],
			[ new \stdClass(), false ],
		];
	}

	/**
	 * @param string $value
	 * @param bool   $expectedResult
	 *
	 * @dataProvider urlProvider
	 */
	public function testCanCheckValueIsUrl( $value, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->isUrl( $value, 'Is not an url.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function urlProvider()
	{
		return [
			# Valid URLs
			[ 'http://example.com', true ],
			[ 'http://test.example.com', true ],
			[ 'https://test.example.com', true ],
			[ 'ftp://test.example.com', true ],
			[ 'sftp://test.example.com', true ],
			[ new ValueObjects\ObjectWithToStringMethod( 'sftp://test.example.com' ), true ],

			# Invalid URLs
			[ '//example.com', false ],
			[ 'example.com', false ],
			[ 'test.example.com', false ],
			[ null, false ],
			[ false, false ],
			[ true, false ],
		];
	}

	/**
	 * @param string $value
	 * @param bool   $expectedResult
	 *
	 * @dataProvider jsonProvider
	 */
	public function testCanCheckValueIsJson( $value, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->isJson( $value, 'Is not json.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function jsonProvider()
	{
		return [
			# Valid json
			[ '1234', true ],
			[ 123.4, true ],
			[ '[]', true ],
			[ '{}', true ],
			[ '[123, 456, "Test"]', true ],
			[ '{"unit": "test"}', true ],

			# Invalid json
			[ '', false ],
			[ '(1234)', false ],
			[ '("Unit-Test")', false ],
			[ null, false ],
			[ false, false ],
			[ true, false ],
		];
	}

	/**
	 * @param mixed $value
	 * @param mixed $key
	 * @param bool  $expectedResult
	 *
	 * @dataProvider keyProvider
	 */
	public function testCanCheckValueHasKey( $value, $key, $expectedResult )
	{
		$validator = new FluidValidator();

		$validator->hasKey( $value, $key, 'Has not key.' );

		$this->assertSame( $expectedResult, $validator->passed() );
	}

	/**
	 * @return array
	 */
	public function keyProvider()
	{
		return [
			# Has key
			[
				[ 'unit' => 'test' ], 'unit', true,
			],
			[
				[ 123 => 'test' ], 123, true,
			],
			[
				[ '' => 'test' ], '', true,
			],
			[
				[ null => 'test' ], null, true,
			],

			# Has not key
			[
				[ 'unit' => 'test' ], 'test', false,
			],
			[
				[ 123 => 'test' ], 456, false,
			],
			[
				[ '' => 'test' ], 'test', false,
			],
			[
				[ null => 'test' ], 0, false,
			],
			[
				new \stdClass(), 0, false,
			],
		];
	}

	/**
	 * @param string $method
	 * @param array  $params
	 *
	 * @dataProvider methodAndParamsProvider
	 */
	public function testCanDelegateDataRetrievalToDataProvider( $method, array $params )
	{
		$dataProvider = $this->getMockBuilder( ProvidesValuesToValidate::class )
		                     ->setMethods( [ 'getValueToValidate' ] )
		                     ->getMock();

		$dataProvider->expects( $this->atLeast( 1 ) )
		             ->method( 'getValueToValidate' )
		             ->with( $params[0] )
		             ->willReturn( $params[0] );

		$validator = new FluidValidator( CheckMode::CONTINUOUS, $dataProvider );

		call_user_func_array( [ $validator, $method ], $params );
	}

	/**
	 * @return array
	 */
	public function methodAndParamsProvider()
	{
		return [
			[ 'isString', [ 'Unit', '' ] ],
			[ 'isStringOrNull', [ 'Unit', '' ] ],
			[ 'isNonEmptyString', [ 'Unit', '' ] ],
			[ 'isNonEmptyStringOrNull', [ 'Unit', '' ] ],
			[ 'isNotEmpty', [ 'Unit', '' ] ],
			[ 'isNotEmptyOrNull', [ 'Unit', '' ] ],
			[ 'isArray', [ [ ], '' ] ],
			[ 'isArrayOrNull', [ [ ], '' ] ],
			[ 'isInt', [ 123, '' ] ],
			[ 'isIntOrNull', [ 123, '' ] ],
			[ 'isIntInRange', [ 1, range( 0, 2 ), '' ] ],
			[ 'isIntInRangeOrNull', [ 1, range( 0, 2 ), '' ] ],
			[ 'isOneStringOf', [ 'Unit', [ 'Unit' ], '' ] ],
			[ 'isOneStringOfOrNull', [ 'Unit', [ 'Unit' ], '' ] ],
			[ 'isSubsetOf', [ [ 'Unit' ], [ 'Unit' ], '' ] ],
			[ 'isSubsetOfOrNull', [ [ 'Unit' ], [ 'Unit' ], '' ] ],
			[ 'isUuid', [ 'Unit', '' ] ],
			[ 'isUuidOrNull', [ null, '' ] ],
			[ 'isEqual', [ 'Unit', 'Unit', '' ] ],
			[ 'isNotEqual', [ 'Unit', 'Unit', '' ] ],
			[ 'isSame', [ 'Unit', 'Unit', '' ] ],
			[ 'isNotSame', [ 'Unit', 'Unit', '' ] ],
			[ 'isNull', [ null, '' ] ],
			[ 'isNotNull', [ null, '' ] ],
			[ 'matchesRegex', [ 'Unit', '#ni#', '' ] ],
			[ 'matchesRegexOrNull', [ 'Unit', '#ni#', '' ] ],
			[ 'hasLength', [ 'Unit', 4, '' ] ],
			[ 'hasLengthOrNull', [ 'Unit', 4, '' ] ],
			[ 'hasMinLength', [ 'Unit', 1, '' ] ],
			[ 'hasMinLengthOrNull', [ 'Unit', 1, '' ] ],
			[ 'hasMaxLength', [ 'Unit', 5, '' ] ],
			[ 'hasMaxLengthOrNull', [ 'Unit', 5, '' ] ],
			[ 'counts', [ [ 'Unit' ], 1, '' ] ],
			[ 'countsOrNull', [ [ 'Unit' ], 1, '' ] ],
			[ 'isEmail', [ 'me@example.com', '' ] ],
			[ 'isEmailOrNull', [ 'me@example.com', '' ] ],
			[ 'isUrl', [ 'http://example.com', '' ] ],
			[ 'isUrlOrNull', [ 'http://example.com', '' ] ],
			[ 'isJson', [ '{"unit": "test"}', '' ] ],
			[ 'isJsonOrNull', [ '{"unit": "test"}', '' ] ],
			[ 'hasKey', [ [ 'unit' => 'test' ], 'unit', '' ] ],
			[ 'hasKeyOrNull', [ [ 'unit' => 'test' ], 'unit', '' ] ],
			[ 'isDate', [ '1970-01-01', 'Y-m-d', '' ] ],
			[ 'isDateOrNull', [ '1970-01-01', 'Y-m-d', '' ] ],
			[ 'isTrue', [ true, '' ] ],
			[ 'isTrueOrNull', [ true, '' ] ],
			[ 'isFalse', [ false, '' ] ],
			[ 'isFalseOrNull', [ false, '' ] ],
		];
	}

	public function testCheckMethodNotFoundExceptionCarriesMethodName()
	{
		$validator = new FluidValidator();

		try
		{
			$validator->someNotExistingMethod();

			$this->assertTrue( false );
		}
		catch ( CheckMethodNotCallable $e )
		{
			$this->assertEquals( 'checkSomeNotExistingMethod', $e->getMethodName() );
		}
	}

	public function testCheckIfExcutesFollowingChecksIfConditionIsTrue()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Empty string 2',
			'Empty string 3',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( true, 2 )
		          ->isNonEmptyString( '', 'Empty string 2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testCheckIfSkipsFollowingChecksIfConditionIsFalse()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( false, 2 )
		          ->isNonEmptyString( '', 'Empty string 2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testDirectChainedCheckIfMethods1()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Empty string 3',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( true, 2 )
		          ->checkIf( false, 2 )
		          ->isNonEmptyString( '', 'Empty string 2.1' )
		          ->isNonEmptyString( '', 'Empty string 2.2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testDirectChainedCheckIfMethods2()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( false, 2 )
		          ->checkIf( true, 2 )
		          ->isNonEmptyString( '', 'Empty string 2.1' )
		          ->isNonEmptyString( '', 'Empty string 2.2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testDirectChainedCheckIfMethods3()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( false, 2 )
		          ->checkIf( false, 2 )
		          ->isNonEmptyString( '', 'Empty string 2.1' )
		          ->isNonEmptyString( '', 'Empty string 2.2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testDirectChainedCheckIfMethods4()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Empty string 2.1',
			'Empty string 2.2',
			'Empty string 3',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( true, 2 )
		          ->checkIf( true, 2 )
		          ->isNonEmptyString( '', 'Empty string 2.1' )
		          ->isNonEmptyString( '', 'Empty string 2.2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testIndirectChainedCheckIfMethods1()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Empty string 2',
			'Empty string 3',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( true, 3 )
		          ->isNonEmptyString( '', 'Empty string 2' )
		          ->checkIf( false, 2 )
		          ->isNonEmptyString( '', 'Empty string 2.1' )
		          ->isNonEmptyString( '', 'Empty string 2.2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testIndirectChainedCheckIfMethods2()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( false, 3 )
		          ->isNonEmptyString( '', 'Empty string 2' )
		          ->checkIf( true, 2 )
		          ->isNonEmptyString( '', 'Empty string 2.1' )
		          ->isNonEmptyString( '', 'Empty string 2.2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testIndirectChainedCheckIfMethods3()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( false, 3 )
		          ->isNonEmptyString( '', 'Empty string 2' )
		          ->checkIf( false, 2 )
		          ->isNonEmptyString( '', 'Empty string 2.1' )
		          ->isNonEmptyString( '', 'Empty string 2.2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testIndirectChainedCheckIfMethods4()
	{
		$validator        = new FluidValidator();
		$expectedMessages = [
			'Empty string 1',
			'Empty string 2',
			'Empty string 2.1',
			'Empty string 2.2',
			'Empty string 3',
			'Not an array',
		];

		$validator->isNonEmptyString( '', 'Empty string 1' )
		          ->checkIf( true, 3 )
		          ->isNonEmptyString( '', 'Empty string 2' )
		          ->checkIf( true, 2 )
		          ->isNonEmptyString( '', 'Empty string 2.1' )
		          ->isNonEmptyString( '', 'Empty string 2.2' )
		          ->isNonEmptyString( '', 'Empty string 3' )
		          ->isArray( false, 'Not an array' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	public function testIfMethods()
	{
		$validator = new FluidValidator();

		$expectedMessages = [
			'Empty string 2',
			'Is not one string of 1',
			'Is not one string of 2',
			'Not an array 1',
			'Is not equal 1',
			'Is not same 1',
			'Invalid date 1',
			'Not an URL 1',
			'Empty string 4',
			'Too long 1',
		];

		$validator->isNonEmptyString( 'unit-test', 'Empty string 1' )
		          ->ifIsNonEmptyString( 'unit-test', 1 )
		          ->isNonEmptyString( '', 'Empty string 2' )
		          ->ifCounts( [ 1, 2 ], 2, 2 )
		          ->isOneStringOf( '3', [ '1', '2' ], 'Is not one string of 1' )
		          ->isOneStringOfOrNull( '4', [ '1', '2' ], 'Is not one string of 2' )
		          ->ifHasKey( [ 'unit' => 'test' ], 'test', 1 )
		          ->counts( [ 1, 2 ], 3, 'Count is wrong' )
		          ->isArray( 'no-array', 'Not an array 1' )
		          ->ifHasLengthOrNull( null, 3, 2 )
		          ->isEqual( 1, 2, 'Is not equal 1' )
		          ->isSame( 1, 2, 'Is not same 1' )
		          ->isDate( '1970-0101', 'Y-m-d', 'Invalid date 1' )
		          ->ifHasLengthOrNull( null, 5, 2 )
		          ->checkIf( true, 2 )
		          ->isUrl( 'no-url', 'Not an URL 1' )
		          ->isNonEmptyString( 'unit-test', 'Empty string 3' )
		          ->isNonEmptyString( '', 'Empty string 4' )
		          ->hasMaxLength( 'four', 3, 'Too long 1' );

		$this->assertTrue( $validator->failed() );
		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}

	/**
	 * @expectedException \hollodotme\FluidValidator\Exceptions\InvalidMessageType
	 */
	public function testInvalidMessageThrowsException()
	{
		$validator = new FluidValidator();
		$validator->isNonEmptyString( '', [ 'invalid' => 'message' ] );
	}

	public function testCanUseGroupedListMessageCollector()
	{
		$messageCollector = new GroupedListMessageCollector();
		$validator        = new FluidValidator( CheckMode::CONTINUOUS, null, $messageCollector );
		$expectedMessages = [
			'unit' => [ 'test', 'unit' ],
			'test' => [ 'unit', 'test' ],
		];

		$validator->isNonEmptyString( '', [ 'unit' => 'test' ] )
		          ->isNonEmptyString( '', [ 'test' => 'unit' ] )
		          ->isNonEmptyString( '', [ 'test' => 'test' ] )
		          ->isNonEmptyString( '', [ 'unit' => 'unit' ] );

		$this->assertEquals( $expectedMessages, $validator->getMessages() );
	}
}

<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Tests\Unit\Validators;

use hollodotme\FluidValidator\Tests\Unit\Fixtures\ValueObjects;
use hollodotme\FluidValidator\Validators\StringValidator;

class StringValidatorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider isStringProvider
	 */
	public function testValueIsString( $value, $expected )
	{
		$result = ( new StringValidator() )->isString( $value );

		$this->assertSame( $expected, $result );
	}

	public function isStringProvider()
	{
		return [
			[ 0, true ],
			[ 1, true ],
			[ 12345, true ],
			[ null, false ],
			[ new \stdClass(), false ],
			[ new ValueObjects\ObjectWithoutToStringMethod( 'Test' ), false ],
			[ new ValueObjects\ObjectWithToStringMethod( 'Test' ), true ],
			[ 'Test', true ],
			[ 1.234, true ],
			[ true, false ],
			[ false, false ],
		];
	}

	/**
	 * @dataProvider isNonEmptyStringProvider
	 */
	public function testValueIsNonEmptyString( $value, $expected )
	{
		$result = ( new StringValidator() )->isNonEmptyString( $value );

		$this->assertSame( $expected, $result );
	}

	public function isNonEmptyStringProvider()
	{
		return [
			[ '', false ],
			[ ' ', false ],
			[ "\n", false ],
			[ "\r", false ],
			[ "\t", false ],
			[ "\x0B", false ],
			[ "\0", false ],
			[ "Unit-Test", true ],
			[ "1", true ],
			[ "0", true ],
			[ "null", true ],
			[ "1.23", true ],
			[ 12, true ],
			[ 12.3, true ],
			[ new ValueObjects\ObjectWithToStringMethod( '' ), false ],
			[ new ValueObjects\ObjectWithToStringMethod( 'Unit-Test' ), true ],
			[ new ValueObjects\ObjectWithoutToStringMethod( 'Unit-Test' ), false ],
			[ new \stdClass(), false ],
			[ false, false ],
			[ true, false ],
			[ null, false ],
		];
	}

	/**
	 * @dataProvider isIntProvider
	 */
	public function testValueIsInt( $value, $expected )
	{
		$result = ( new StringValidator() )->isInt( $value );

		$this->assertSame( $expected, $result );
	}

	public function isIntProvider()
	{
		return [
			[ false, false ],
			[ true, false ],
			[ null, false ],
			[ 0, true ],
			[ 1, true ],
			[ -1, true ],
			[ '-1', true ],
			[ '0', true ],
			[ '1', true ],
			[ '13232345546548785456464121515454', false ],
			[ 13232345546548785456464121515454, false ],
			[ '12.3', false ],
			[ 12.3, false ],
			[ new \stdClass(), false ],
			[ new ValueObjects\ObjectWithToStringMethod( '' ), false ],
			[ new ValueObjects\ObjectWithToStringMethod( '12345' ), true ],
			[ new ValueObjects\ObjectWithoutToStringMethod( '12345' ), false ],
		];
	}

	/**
	 * @dataProvider isUuidProvider
	 */
	public function testValueIsAUuid( $value, $expected )
	{
		$result = ( new StringValidator() )->isUuid( $value );

		$this->assertSame( $expected, $result );
	}

	public function isUuidProvider()
	{
		return [
			[ '00000000-0000-0000-0000-000000000000', true ],
			[ '01a2b3c4-D5F6-7a8b-9c0D-1E2f3a4B5c6D', true ],
			[ 'AAAAAAAA-BBBB-CCCC-DDDD-EEEEEEEEEEEE', true ],
			[ '12345678-1234-5678-9101-121314151617', true ],
			[ '12345678-1234-5678-9101-121314151617', true ],
			[ new ValueObjects\ObjectWithToStringMethod( '12345678-1234-5678-9101-121314151617' ), true ],
			[ new ValueObjects\ObjectWithoutToStringMethod( '12345678-1234-5678-9101-121314151617' ), false ],
			[ 'GGGGGGGG-HHHH-IIII-JJJJ-KKKKKKKKKKKK', false ],
			[ 0, false ],
			[ 123, false ],
			[ '0', false ],
			[ false, false ],
			[ true, false ],
			[ null, false ],
			[ 12.3, false ],
		];
	}

	/**
	 * @dataProvider isEmailProvider
	 */
	public function testValueIsAnEmail( $value, $expected )
	{
		$result = ( new StringValidator() )->isEmail( $value );

		$this->assertSame( $expected, $result );
	}

	public function isEmailProvider()
	{
		return [
			# valid addresses
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
			[ 'email@example.web', true ],
			[ 'firstname-lastname@example.com', true ],
			[ 'much."more\ unusual"@example.com', true ],
			[ 'very.unusual."@".unusual.com@example.com', true ],
			[ new ValueObjects\ObjectWithToStringMethod( 'me@example.com' ), true ],
			# Invalid addresses
			[ 'email@123.123.123.123', false ],
			[ 'very."(),:;<>[]".VERY."very@\\ "very".unusual@strange.example.com', false ],
			[ 'me@-online.de', false ],
			[ 'plainaddress', false ],
			[ '#@%^%#$@#$@#.com', false ],
			[ '@example.com', false ],
			[ 'Joe Smith <email@example.com> ', false ],
			[ 'email.example.com', false ],
			[ 'email@example@example.com', false ],
			[ '.email@example.com', false ],
			[ 'email.@example.com', false ],
			[ 'email..email@example.com', false ],
			[ 'あいうえお@example.com', false ],
			[ 'email@example.com (Joe Smith)', false ],
			[ 'email@example', false ],
			[ 'email@-example.com', false ],
			[ 'email@111.222.333.44444', false ],
			[ 'email@example..com', false ],
			[ 'Abc..123@example.com', false ],
			[ '"(),:;<>[\]@example.com', false ],
			[ 'just”not”right@example.com', false ],
			[ 'this\ is"really"not\allowed@example.com', false ],
			[ '', false ],
			[ null, false ],
			[ false, false ],
			[ true, false ],
			[ 1234, false ],
			[ new \stdClass(), false ],
			[ new ValueObjects\ObjectWithoutToStringMethod( 'me@example.com' ), false ],
		];
	}

	/**
	 * @dataProvider isUrlProvider
	 */
	public function testValueIsAnUrl( $value, $expected )
	{
		$result = ( new StringValidator() )->isUrl( $value );

		$this->assertSame( $expected, $result );
	}

	public function isUrlProvider()
	{
		return [
			# Invalid urls
			[ null, false ],
			[ false, false ],
			[ true, false ],
			[ '', false ],
			[ ' ', false ],
			[ new ValueObjects\ObjectWithoutToStringMethod( '//www.example.com' ), false ],
			[ 'http//www.example.com', false ],
			[ 'https//www.example.com', false ],
			# Valid urls
			[ 'ftp://www.example.com', true ],
			[ new ValueObjects\ObjectWithToStringMethod( '//www.example.com' ), false ],
			[ 'http://www.example.com', true ],
			[ 'https://www.example.com', true ],
			[ '//www.example.com/cdn/images.png', false ],
			[ '//www.example.com:8080/cdn/images.png', false ],
			[ 'http://www.example.com:8080/cdn/images.png', true ],
			[ 'https://www.example.com:8080/cdn/images.png', true ],
			[ 'https://127.0.0.1:8080/', true ],
		];
	}

	/**
	 * @dataProvider isJsonProvider
	 */
	public function testValueIsJson( $value, $expected )
	{
		$result = ( new StringValidator() )->isJson( $value );

		$this->assertSame( $expected, $result );
	}

	public function isJsonProvider()
	{
		return [
			[ '', false ],
			[ ' ', false ],
			[ false, false ],
			[ null, false ],
			[ true, false ],
			[ '{}', true ],
			[ '[]', true ],
			[ '["Unit","Test"]', true ],
			[ '["Unit","Test",]', false ],
			[ '{"Unit":"Test"}', true ],
			[ '{"Unit":"Test",}', false ],
			[ new ValueObjects\ObjectWithToStringMethod( '{"Unit":"Test"}' ), true ],
			[ new ValueObjects\ObjectWithoutToStringMethod( '{"Unit":"Test"}' ), false ],
			[ new \stdClass(), false ],
		];
	}
}

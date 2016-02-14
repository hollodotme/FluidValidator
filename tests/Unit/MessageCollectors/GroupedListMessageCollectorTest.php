<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Tests\Unit\MessageCollectors;

use hollodotme\FluidValidator\MessageCollectors\GroupedListMessageCollector;

class GroupedListMessageCollectorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @param mixed $message
	 * @param bool  $expectedResult
	 *
	 * @dataProvider messageTypeProvider
	 */
	public function testIsMessageValid( $message, $expectedResult )
	{
		$messageCollector = new GroupedListMessageCollector();

		$result = $messageCollector->isMessageValid( $message );

		$this->assertInternalType( 'boolean', $result );
		$this->assertSame( $expectedResult, $result );
	}

	/**
	 * @return array
	 */
	public function messageTypeProvider()
	{
		return [
			# Valid messages
			[ [ 'message' ], true ],
			[ [ 1 => 'message' ], true ],
			[ [ 'key' => 'message' ], true ],
			[ [ 'key' => 1 ], true ],
			[ [ 'key' => true ], true ],
			[ [ 'key' => 12.3 ], true ],
			[ [ 'key1' => 12.3, 'key2' => 'test' ], true ],
			[ [ 1 ], true ],
			[ [ true ], true ],
			[ [ false ], true ],
			[ [ 12.3 ], true ],

			# Invalid messages
			[ [ [ 'message' ] ], false ],
			[ [ 1 => [ 'message' ] ], false ],
			[ [ 'key' => [ 'message' ] ], false ],
			[ [ 'key' => new \stdClass() ], false ],
			[ [ 'key1' => 12.3, 'key2' => new \stdClass() ], false ],
			[ 'string', false ],
			[ new \stdClass, false ],
		];
	}

	public function testMessagesAreGroupedByKey()
	{
		$messageCollector = new GroupedListMessageCollector();

		$expectedMessages = [
			'unit' => [ 'test', 'unit' ],
			'test' => [ 'unit', 'test' ],
		];

		$messageCollector->addMessage( [ 'unit' => 'test' ] );
		$messageCollector->addMessage( [ 'test' => 'unit' ] );
		$messageCollector->addMessage( [ 'test' => 'test' ] );
		$messageCollector->addMessage( [ 'unit' => 'unit' ] );

		$this->assertInternalType( 'array', $messageCollector->getMessages() );
		$this->assertEquals( $expectedMessages, $messageCollector->getMessages() );
	}

	public function testCanClearMessages()
	{
		$messageCollector = new GroupedListMessageCollector();

		$messageCollector->addMessage( [ 'unit' => 'test' ] );
		$messageCollector->addMessage( [ 'test' => 'unit' ] );

		$this->assertCount( 2, $messageCollector->getMessages() );

		$messageCollector->clearMessages();

		$this->assertCount( 0, $messageCollector->getMessages() );
	}
}

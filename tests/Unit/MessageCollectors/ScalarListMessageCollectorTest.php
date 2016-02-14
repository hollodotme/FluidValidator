<?php
/**
 * @author hollodotme
 */

namespace hollodotme\FluidValidator\Tests\Unit\MessageCollectors;

use hollodotme\FluidValidator\MessageCollectors\ScalarListMessageCollector;

class ScalarListMessageCollectorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @param mixed $message
	 * @param bool  $expectedResult
	 *
	 * @dataProvider messageTypeProvider
	 */
	public function testIsMessageValid( $message, $expectedResult )
	{
		$messageCollector = new ScalarListMessageCollector();

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
			[ 1, true ],
			[ 'message', true ],
			[ true, true ],
			[ false, true ],
			[ 12.3, true ],

			# Invalid messages
			[ [ 'message' ], false ],
			[ new \stdClass(), false ],
			[ null, false ],
		];
	}

	public function testCanRetrieveAddedMessages()
	{
		$messageCollector = new ScalarListMessageCollector();
		$expectedMessages = [
			'Unit-Test',
			'Message',
		];

		$messageCollector->addMessage( 'Unit-Test' );
		$messageCollector->addMessage( 'Message' );

		$this->assertEquals( $expectedMessages, $messageCollector->getMessages() );
	}

	public function testCanClearMessages()
	{
		$messageCollector = new ScalarListMessageCollector();

		$messageCollector->addMessage( 'Unit-Test' );
		$messageCollector->addMessage( 'Message' );

		$this->assertCount( 2, $messageCollector->getMessages() );

		$messageCollector->clearMessages();

		$this->assertCount( 0, $messageCollector->getMessages() );
	}
}

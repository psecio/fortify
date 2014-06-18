<?php

namespace Psecio\Fortify;

class SubjectTest extends \PHPUnit_Framework_TestCase
{
	private $subject;

	public function setUp()
	{
		$this->subject = new \Psecio\Fortify\Subject();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * Test the getter/setters of properties on the Subject
	 */
	public function testGetSetProperty()
	{
		$name = 'test';
		$value = 'foo';

		$this->subject->setProperty($name, $value);
		$this->assertEquals(
			$this->subject->getProperty($name),
			$value
		);
	}
}
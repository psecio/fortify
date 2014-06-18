<?php

namespace Psecio\Fortify\Decider\Password;

class HtpasswdTest extends \PHPUnit_Framework_TestCase
{
	private $password;

	public function setUp()
	{

		$this->password = new Htpasswd();
	}

	public function tearDown()
	{
		unset($this->password);
	}

	/**
	 * Test that a valid Apache-md5 password matches
	 */
	public function testMd5ValidateValid()
	{
		$username = 'test';
		$match = '$apr1$nLWj7RML$uhtusd1VIEX5rY7l7CAO60';
		$password = 'testing123';
		$fileData = array($username.':'.$match);

		$subject = new \Psecio\Fortify\Subject(array(
			'username' => $username,
			'password' => $password
		));
		$passwd = new Htpasswd();
		$passwd->setData(array(
			'file' => $fileData
		));

		$this->assertTrue($passwd->evaluate($subject));
	}
}
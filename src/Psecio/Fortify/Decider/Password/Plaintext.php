<?php

namespace Psecio\Fortify\Decider\Password;

class Plaintext extends \Psecio\Fortify\Decider\Password
{
	/**
	 * Test the "password" value on the Subject against the
	 *   plaintext value given
	 *
	 * @param \Psecio\Fortify\Subject $subject Subject for evaluation
	 * @throws \InvalidArgumentException If password is not defined
	 * @return boolean Pass/fail status
	 */
	public function evaluate($subject)
	{
		$password = $subject->getProperty('password');
		$compare = $this->getData('password');

		if ($compare == null || $password == null) {
			throw new \InvalidArgumentException('Password not defined!');
		}

		return ($password === $compare);
	}
}
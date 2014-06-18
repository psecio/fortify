<?php

namespace Psecio\Fortify\Decider\Password;

class Plaintext extends \Psecio\Fortify\Decider\Password
{
	public function evaluate($subject)
	{
		$password = $subject->getProperty('password');
		$compare = $this->getData('password');

		if ($compare == null) {
			throw new \InvalidArgumentException('Password not defined!');
		}

		return ($password === $compare);
	}
}
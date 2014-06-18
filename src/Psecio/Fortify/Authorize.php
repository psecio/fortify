<?php

namespace Psecio\Fortify;

class Authorize
{
	private $decider;

	public function __construct(\Psecio\Fortify\Decider $decider)
	{
		$this->setDecider($decider);
	}

	public function setDecider(\Psecio\Fortify\Decider $decider)
	{
		$this->decider = $decider;
		return $this;
	}
	public function getDecider()
	{
		return $this->decider;
	}

	public function evaluate(\Psecio\Fortify\Subject $subject)
	{
		return $this->getDecider()->evaluate($subject);
	}
}
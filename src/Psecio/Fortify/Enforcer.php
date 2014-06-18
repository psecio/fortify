<?php

namespace Psecio\Fortify;

abstract class Enforcer
{
	/**
	 * Current Decider object
	 * @var \Psecio\Fortify\Decider instance
	 */
	private $decider;

	/**
	 * Initialize the object with the given Decider
	 * 
	 * @param \Psecio\Fortify\Decider $decider Decider instance
	 */
	public function __construct(\Psecio\Fortify\Decider $decider)
	{
		$this->setDecider($decider);
	}

	/**
	 * Set the current Decider instance
	 * 
	 * @param \Psecio\Fortify\Decider $decider Decider instance
	 * @return \Psecio\Fortify\Enforcer instance
	 */
	public function setDecider(\Psecio\Fortify\Decider $decider)
	{
		$this->decider = $decider;
		return $this;
	}

	/**
	 * Get the current Decider instance
	 * 
	 * @return \Psecio\Fortify\Decider instance
	 */
	public function getDecider()
	{
		return $this->decider;
	}

	/**
	 * Run the evaluation of the Subject with the Decider
	 * 
	 * @param \Psecio\Fortify\Subject $subject Subject instance
	 * @return boolean Pass/fail status of evaluation
	 */
	public function evaluate(\Psecio\Fortify\Subject $subject)
	{
		return $this->getDecider()->evaluate($subject);
	}
}
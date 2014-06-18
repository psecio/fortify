<?php

namespace Psecio\Fortify\Decider;

class Permission extends \Psecio\Fortify\Decider
{
	/**
	 * Evaluate the Subject's permissions
	 *
	 * @param \Psecio\Fortify\Subject $subject Subject instance
	 * @return boolean Pass/fail status
	 */
	public function evaluate($subject)
	{
		$permissions = $subject->getProperty('permissions');

		$check = $this->getData('permissions');
		$type = $this->getData('type');

		if ($type == null) {
			$type = 'exact';
		}
		$method = 'validate'.ucwords(strtolower($type));
		return $this->$method($permissions, $check);
	}

	/**
	 * Validate that all of the permissions given exist in
	 * 	the Subject's permission list
	 */
	public function validateExact($permissions, $check)
	{
		$found = 0;
		foreach ($check as $perm) {
			if (in_array($perm, $permissions) === true) {
				$found++;
			}
		}
		return ($found === count($check));
	}

	/**
	 * Validate that the Subject's permissions contain
	 * 	at least one of the pemrissions given. Returns on first match
	 */
	public function validateContains($permissions, $check)
	{
		$found = 0;
		foreach ($check as $perm) {
			if (in_array($perm, $permissions) === true) {
				return true;
			}
		}
		return false;
	}
}
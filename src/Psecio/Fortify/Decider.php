<?php

namespace Psecio\Fortify;

class Decider
{
	/**
	 * Current Decider instance
	 *
	 * @var \Psecio\Fortify\Decider
	 */
	protected static $decider;

	/**
	 * Current Decider data
	 * @var array
	 */
	protected $data = array();

	/**
	 * Factory to create Decider instances
	 *
	 * @param string $type Type to create (ex. "password.htpasswd")
	 * @param array $data Data to pass along to the Decider
	 * @return \Psecio\Fortify\Decider|null
	 */
	public static function create($type, $data)
	{
		// split the type and make the object
		$parts = explode('.', $type);
		$class = "\\Psecio\\Fortify\\Decider";

		foreach ($parts as $part) {
			$class .= "\\".ucwords(strtolower($part));
		}

		if (class_exists($class) == true) {
			self::$decider = new $class();
			self::$decider->setData($data);
			return self::$decider;
		}
		return null;
	}

	/**
	 * Set the data for the current decider
	 *
	 * @param array $data
	 * @return \Psecio\Fortify\Decider instance
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * Get the current data (all or by name)
	 *
	 * @param string $name Name of data to locate [optional]
	 * @return array|null|mixed
	 */
	public function getData($name = null)
	{
		if ($name === null) {
			return $this->data;
		} elseif ($name !== null) {
			return (isset($this->data[$name])) ? $this->data[$name] : null;
		}
	}

	/**
	 * Set current Decider instance
	 *
	 * @param \Psecio\Fortify\Decider $decider Decider instance
	 */
	public function setDecider(\Psecio\Fortify\Decider $decider)
	{
		self::$decider = $decider;
	}

	/**
	 * Run the Decider evaluation on the given Subject
	 *
	 * @param \Psecio\Fortify\Subject $subject Subject instance
	 * @return boolean Pass/fail status
	 */
	public function evaluate(\Psecio\Fortify\Subject $subject)
	{
		return self::getDecider()->evaluate($subject);
	}
}
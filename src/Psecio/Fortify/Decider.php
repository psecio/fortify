<?php

namespace Psecio\Fortify;

class Decider
{
	protected static $decider;
	protected $data = array();

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

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	public function getData($name = null)
	{
		if ($name === null) {
			return $this->data;
		} elseif ($name !== null) {
			return (isset($this->data[$name])) ? $this->data[$name] : null;
		}
	}

	public function setDecider($decider)
	{
		self::$decider = $decider;
	}

	public function evaluate(\Psecio\Fortify\Subject $subject)
	{
		return self::getDecider()->evaluate($subject);
	}
}
<?php

namespace Psecio\Fortify;

class Subject
{
	private $properties = array();

	public function __construct(array $properties = array())
	{
		if (!empty($properties)) {
			foreach ($properties as $name => $value) {
				$this->setProperty($name, $value);
			}
		}
	}

	public function setProperty($name, $value)
	{
		$this->properties[$name] = $value;
		return $this;
	}

	public function getProperties()
	{
		return $this->properties;
	}

	public function getProperty($name)
	{
		return (isset($this->properties[$name]))
			? $this->properties[$name] : null;
	}
}
<?php

namespace Psecio\Fortify;

class Subject
{
	/**
	 * Current object properties
	 * @var array
	 */
	private $properties = array();

	/**
	 * Create the object and initialize properties if given
	 *
	 * @param array $properties
	 */
	public function __construct(array $properties = array())
	{
		if (!empty($properties)) {
			foreach ($properties as $name => $value) {
				$this->setProperty($name, $value);
			}
		}
	}

	/**
	 * Set a property on the current object
	 *
	 * @param string $name Name of property
	 * @param mixed $value Value for property
	 * @return \Psecio\Fortify\Subject instance
	 */
	public function setProperty($name, $value)
	{
		$this->properties[$name] = $value;
		return $this;
	}

	/**
	 * Get the full set of current properties
	 *
	 * @return array Property set
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/**
	 * Get one specific property
	 *
	 * @param string $name
	 * @return mixed If the property is not set, returns null
	 */
	public function getProperty($name)
	{
		return (isset($this->properties[$name]))
			? $this->properties[$name] : null;
	}
}
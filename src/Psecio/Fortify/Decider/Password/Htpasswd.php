<?php

namespace Psecio\Fortify\Decider\Password;

class Htpasswd extends \Psecio\Fortify\Decider\Password
{
	public $data = array();

	/**
	 * Test the "password" value on the Subject against the
	 *   value in a .htpasswd file (exact matching on username)
	 * 
	 * @param \Psecio\Fortify\Subject $subject Subject for evaluation
	 * @return boolean Pass/fail status
	 */
	public function evaluate($subject)
	{
		$file = $this->getData('file');
		$username = $subject->getProperty('username');
		$password = $subject->getProperty('password');

		if ($file == null || !is_file($file)) {
			throw new \InvalidArgumentException('File is not valid ('.$file.').');
		}

		$contents = file($file);
		foreach ($contents as $line) {
			list($htUsername, $htPassword) = explode(':', $line);
			if ($username == $htUsername) {

				$type = $this->determineType($htPassword);
				$method = 'validate'.ucwords($type);
				return $this->$method($password, $htPassword);
			}
		}

		return false;
	}

	/**
	 * Validate the (Apache) md5 formatted value
	 * 
	 * @param string $input Input to validate
	 * @param string $compare Value coming from the .htpasswd file
	 * @return boolean Pass/fail status
	 */
	public function validateMd5($input, $compare)
	{
		$compare = trim($compare);
		$salt = trim(preg_replace('/^\$apr1\$([^$]+)\$.*/', '\\1', $compare));
		return $this->calculateMd5($salt, $input) === $compare;
	}

	/**
	 * Generate the (Apache) md5 hash based on the given salt and input 
	 *   (input is the user input here)
	 * Modifed from code found on ethelo.com (by Morten Haraldsen)
	 * 
	 * @param string $salt Salt to use on the hash generation
	 * @param string $input User inputted value for hash generation
	 */
	public function calculateMd5($salt, $input)
	{
		$hash = '';
	    $length = strlen($input);
	    $text = $input.'$apr1$'.$salt;
	    $bin = pack("H32", md5($input.$salt.$input));

	    for($i = $length; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
	    for($i = $length; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $input{0}; }
	    $bin = pack("H32", md5($text));
	    for($i = 0; $i < 1000; $i++) {
	        $new = ($i & 1) ? $input : $bin;
	        if ($i % 3) $new .= $salt;
	        if ($i % 7) $new .= $input;
	        $new .= ($i & 1) ? $bin : $input;
	        $bin = pack("H32", md5($new));
	    }
	    for ($i = 0; $i < 5; $i++) {
	        $k = $i + 6;
	        $j = $i + 12;
	        if ($j == 16) $j = 5;
	        $hash = $bin[$i].$bin[$k].$bin[$j].$hash;
	    }
	    $hash = chr(0).chr(0).$bin[11].$hash;
	    $hash = strtr(strrev(substr(base64_encode($hash), 2)),
	    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
	    "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
	 
	    $computed_hash = "$"."apr1"."$".$salt."$".$hash;
        return $computed_hash;
	}

	public function validateSha1($input, $compare)
	{
		throw new \Exception('Not implemented yet').
	}
	public function validateCrypt($input, $compare)
	{
		throw new \Exception('Not implemented yet').
	}

	/**
	 * Determine the type of hash the .htpasswd file is using
	 * 
	 * @param string $password Password value from .htpasswd file
	 * @return string Hash type
	 */
	public function determineType($password)
	{
		$substr = substr($password, 0, 5);
		switch ($substr) {
			case '$apr1':
				return 'md5';
			case '{SHA}':
				return 'sha1';
			default:
				return 'crypt';
		}
	}
}

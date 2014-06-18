Fortify: Unified Authentication & Authorization Interface
===========================

The aim of Fortify is to provide a single, simple interface for handling authentication
and authorization needs.

Installation
------------

### Using Composer

```
{
    "require": {
        "psecio/fortify": "dev-master"
    }
}
```

Currently there are no other dependencies needed.

Sample Authentication Usage
------------------

```php
$subject = new \Psecio\Fortify\Subject(array(
	'username' => 'test',
	'password' => 'testing123'
));

$decider = \Psecio\Fortify\Decider::create(
	'password.htpasswd',
	array(
		'password' => 'foo',
		'file' => file_get_contents('/var/www/test/fortify/.htpasswd')
	)
);

$authz = new \Psecio\Fortify\Authorize($decider);
if ($authz->evaluate($subject) === true) {
	echo 'Authorized against htpasswd file!';
} else {
	echo 'Not authorized, bummer...';
}

```
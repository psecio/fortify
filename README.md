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

### Sample Authentication Usage

```php
<?php
$subject = new \Psecio\Fortify\Subject(array(
	'username' => 'test',
	'password' => 'testing123'
));

$decider = \Psecio\Fortify\Decider::create(
	'password.htpasswd',
	array(
		'file' => file('/var/www/test/fortify/.htpasswd')
	)
);
$authn = new \Psecio\Fortify\Authenticate($decider);
if ($authn->evaluate($subject) === true) {
	echo 'Authenticated against htpasswd file!';
} else {
	echo 'Not authorized, bummer...';
}
?>
```

### Sample Authorization Usage

```php
<?php
$subject = new \Psecio\Fortify\Subject(array(
	'username' => 'test',
	'password' => $password,
	'permissions' => array(
		'foo1', 'foo2', 'foo3'
	)
));

$decider = \Psecio\Fortify\Decider::create(
	'permission',
	array(
		'permissions' => array('foo1', 'foo2')
	)
);

$authz = new \Psecio\Fortify\Authorize($decider);
if ($authn->evaluate($subject) === true) {
	echo 'Subject has both permissions foo1 and foo2!';
} else {
	echo 'Not authorized, bummer...';
}
?>
```
<?php

namespace Psecio\Fortify\Decider\Password;

class Ldap extends \Psecio\Fortify\Decider\Password
{
    /**
     * Test the "password" value on the Subject against the
     *   LDAP server information (using ldap_bind method)
     *
     * @param \Psecio\Fortify\Subject $subject Subject for evaluation
     * @throws \InvalidArgumentException If password is not defined
     * @throws \DomainException If LDAP connection could not be created
     * @return boolean Pass/fail status
     */
    public function evaluate($subject)
    {
        $server = $this->getData('server');
        $username = $subject->getProperty('username');
        $password = $subject->getProperty('password');

        if ($username == null || $password == null) {
            throw new \InvalidArgumentException('Username/password not defined!');
        }

        $ldap = \ldap_connect($server);
        if ($ldap == false) {
            throw new \DomainException('LDAP connection could not be established');
        }

        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

        $result = @\ldap_bind($ldap, $username, $password);
        return ($result == false) ? false : true;
    }
}
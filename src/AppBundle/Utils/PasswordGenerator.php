<?php

namespace AppBundle\Utils;

use AppBundle\Utils\PasswordGeneratorInterface;

class PasswordGenerator implements PasswordGeneratorInterface
{
    public function generatePassword()
    {
        return $this->getRandom();
    }

    public function getRandom()
    {
		$passwordRand = bin2hex(random_bytes(30));

        return $passwordRand;
    }
}

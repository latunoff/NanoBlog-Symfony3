<?php

namespace AppBundle\Utils;

use AppBundle\Utils\TokenGeneratorInterface;

class TokenGenerator implements TokenGeneratorInterface
{
    public function generateToken()
    {
        return rtrim(strtr(base64_encode($this->getRandom()), '+/', '-_'), '=');
    }

    public function getRandom()
    {
        return hash('sha256', uniqid(mt_rand(), true), true);
    }
}

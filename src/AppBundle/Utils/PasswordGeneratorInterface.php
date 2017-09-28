<?php

namespace AppBundle\Utils;

interface PasswordGeneratorInterface
{
    /**
     * @return string
     */
    public function generatePassword();
}


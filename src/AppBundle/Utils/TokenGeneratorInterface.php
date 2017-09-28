<?php

namespace AppBundle\Utils;

interface TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generateToken();
}


<?php

namespace AppBundle\Utils;

class Slugger
{
    /**
     * @param string $string
     *
     * @return string
     */
    public function slugify($string)
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower(strip_tags($string))), '-');
    }
}

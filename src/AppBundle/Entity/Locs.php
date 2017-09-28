<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Locs
{
    protected $locs;

    public function __construct()
    {
        $this->locs = new ArrayCollection();
    }

    public function getGardens()
    {
        return $this->locs;
    }
}
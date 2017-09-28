<?php

namespace AppBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\User;

class EmailEvent extends Event
{
    const NAME = 'register.event.email_event';

    protected $user;

    protected $request;

    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getUser()
    {
        return $this->user;
    }
}

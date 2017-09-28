<?php

namespace AppBundle\EventListener;

use AppBundle\Event\EmailEvent;
//use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class MailListener
{
    protected $twig;

    protected $mailer;

    protected $router;

    public function __construct(RouterInterface $router, \Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->router = $router;
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

	public function onMailEvent(EmailEvent $event)
    {
		$name = $event->getUser()->getName();
		$email = $event->getUser()->getEmail();
		$password = $event->getUser()->getPassword();
        $token = $event->getUser()->getToken();

        $url = $this->router->generate('user_registration_confirm', ['token' => $token]);

		$body = $this->renderTemplate($name, $token, $url);

		$message = \Swift_Message::newInstance()
		    ->setSubject('Hello ' . $name)
		    ->setFrom($email)
		    ->setTo($email)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
	}

    public function renderTemplate($name, $token, $url)
    {
		return $this->twig->render(
            'Emails/registration.html.twig',
            [
                'name' => $name,
                'token' => $token,
                'url' => $url
            ]
        );

    }
}

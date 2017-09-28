<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Event\EmailEvent;
use AppBundle\Utils\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
	/**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $tokenGenerator = new TokenGenerator();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
			$user->setRoles(["ROLE_USER"]);
            $user->setIsActive(0);
            $token = $tokenGenerator->generateToken();
            $user->setToken($token);

            $event = new EmailEvent($request, $user);
            $dispatcher = $this->get('event_dispatcher');
	        $dispatcher->dispatch(EmailEvent::NAME, $event);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice','Registration success!');

            return $this->redirectToRoute('user_registration');
        }

        return $this->render('registration/register.html.twig', [
        	'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/register/confirm/{token}", name="user_registration_confirm")
     */
    public function confirmEmailAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['token' => $token]);
        $user->setIsActive(1);

        $em->persist($user);
        $em->flush();

        return $this->render('registration/confirmRegister.html.twig', [
            'token' => $token,
        ]);
    }
}

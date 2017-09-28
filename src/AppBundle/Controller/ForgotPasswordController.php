<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\ForgotPasswordType;
use AppBundle\Event\EmailForgotPasswordEvent;
use AppBundle\Utils\PasswordGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ForgotPasswordController extends Controller
{
	/**
     * @Route("/forgotPassword", name="user_forgot_password")
     * @Method({"GET","POST"})
     */
    public function forgotPasswordAction(Request $request)
    {
	    $user = new User;
        $form = $this->createForm(ForgotPasswordType::class, $user);
      	$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$email = $request->request->get('forgot_password')['email'];
            $em = $this->getDoctrine()->getManager();
			$userRepository = $em->getRepository(User::class)->findOneBy(['email' => $email]);

			$passwordRand = new PasswordGenerator();
            $userRepository->setPassword($passwordRand->generatePassword());

            $event = new EmailForgotPasswordEvent($userRepository);
   			$dispatcher = $this->get('event_dispatcher');
			$dispatcher->dispatch(EmailForgotPasswordEvent::NAME, $event);

			$em->persist($userRepository);
			$em->flush();

            $this->addFlash('notice','Change password success!');

            return $this->redirectToRoute('user_forgot_password');
		}

        return $this->render('security/forgotPassword.html.twig', [
        	'form' => $form->createView()
        ]);
	}
}

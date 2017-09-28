<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\UserProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class UserProfileController extends Controller
{
	/**
     * @Route("/userProfile/{id}", name="user_profile")
     * @Method({"GET","POST"})
     */
    public function profileUserAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$user = $this->get('security.token_storage')->getToken()->getUser();
	    $userRepository = $em->getRepository(User::class)->find($user->getId());

	    $form = $this->createForm(UserProfileType::class, $userRepository);
        $form->handleRequest($request);

		if ($form->isValid()) {
			$em->persist($userRepository);
            $em->flush();

            $this->addFlash('notice', 'Profile Update Success!');
        }

		return $this->render('user/userProfile.html.twig', [
			'user' => $user->getId(),
	        'edit_profile_form' => $form->createView(),
        ]);
    }
}

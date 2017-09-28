<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 * @Security("has_role('ROLE_ADMIN')")
 *
 */
class UserController extends Controller
{
    /**
     * @Route("/user", defaults={"page": 1}, name="admin_user_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="admin_post_index_paginated")
     * @Method("GET")
     * @Cache(smaxage="10")
     */
    public function indexAction($page)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Access Denied!');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(User::class)->findLatest($page);

        return $this->render('admin/user/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, name="admin_user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        if (null === $this->getUser()) {
            throw $this->createAccessDeniedException('Users can only be viewed by administrators an blog.');
        }

        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);

    }

    /**
     * @Route("/user/{id}", name="admin_user_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('notice', 'Delete User Successfully');

        return $this->redirectToRoute('admin_user_index');
    }
}

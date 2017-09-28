<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\PostType;
use AppBundle\Entity\Post;
use AppBundle\Security\Authorization\Voter\PostVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * @Route("/admin/post")
 * @Security("has_role('ROLE_ADMIN')")
 */
class PostController extends Controller
{
    /**
     * @Route("/", defaults={"page": 1}, name="admin_index")
     * @Route("/", defaults={"page": 1}, name="admin_post_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="admin_index_paginated")
     * @Method("GET")
     * @Cache(smaxage="10")
     */
    public function indexAction($page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $posts = $entityManager->getRepository(Post::class)->findLatest($page);

        return $this->render('admin/blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/new", name="admin_post_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $post->setAuthorEmail($this->getUser()->getEmail());

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $post->setSlug($this->get('slugger')->slugify($post->getTitleEn()));

            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'post.created_successfully');

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/blog/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, name="admin_post_show")
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
        // проверка на авторство
        if (null === $this->getUser() || !$post->isAuthor($this->getUser())) {
            throw $this->createAccessDeniedException('Posts can only be shown to their authors.');
        }

        $deleteForm = $this->createDeleteForm($post);

        return $this->render('admin/blog/show.html.twig', [
            'post'        => $post,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_post_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Post $post, Request $request)
    {
        if (null === $this->getUser() || !$post->isAuthor($this->getUser())) {
            throw $this->createAccessDeniedException('Posts can only be edited by their authors.');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $editForm = $this->createForm(PostType::class, $post);
        $deleteForm = $this->createDeleteForm($post);

        $editForm->handleRequest($request);
        //echo $this->container->getParameter('app_locales');

        $this->denyAccessUnlessGranted(PostVoter::VIEW, $post);

        if ($editForm->isValid()) {
            $post->setSlug($this->get('slugger')->slugify($post->getTitleEn()));
            $entityManager->flush();

            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('admin_post_edit', ['id' => $post->getId()]);
        }

        return $this->render('admin/blog/edit.html.twig', [
            'post'        => $post,
            'loc'         => $request->getLocale(),
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_post_delete")
     * @Method("DELETE")
     * @Security("post.isAuthor(user)")
     */
    public function deleteAction(Post $post, Request $request)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($post);
            $entityManager->flush();

            $this->addFlash('success', 'post.deleted_successfully');
        }

        return $this->redirectToRoute('admin_post_index');
    }

    /**
     * @param Post $post The post object
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_post_delete', ['id' => $post->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

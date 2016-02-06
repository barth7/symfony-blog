<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Post;

class BlogController extends Controller
{

    public function adminAction(Request $request, $page)
    {
        
        $posts = $this->getDoctrine()->getEntityManager();
        $query = $posts->createQuery('
                SELECT p
                FROM AppBundle:Post p
                ORDER BY p.createdDate DESC
            ');

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $request->query->get('page', $page), 10);
        $pagination->setUsedRoute('_admin_index_paginated');
        var_dump('admin!');
        return $this->render('blog/showPosts.html.twig', array(
            'posts' => $pagination,
            'delete_option' => true
        ));
    }
    public function deleteAction(Request $request, Post $id){
        if (!$id) {
            throw $this->createNotFoundException('No post found');
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute('_admin_vire');
    }
    public function newPostAction(Request $request){
        $NewPost = new Post();

        $form = $this->createFormBuilder($NewPost)
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('author', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create New Post'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $NewPost->setSlug(preg_replace(
                '/[^a-z0-9]/', '-', strtolower(trim(strip_tags($NewPost->getTitle())))));
            var_dump($data);
            $this->get('app.newpost')->newPost($data);

            return $this->redirectToRoute('_admin_vire');
        }

        return $this->render('blog/newPost.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
?>
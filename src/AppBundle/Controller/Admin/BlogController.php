<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            'posts' => $pagination
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

}
?>
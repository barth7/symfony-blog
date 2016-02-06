<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Post;

class BlogController extends Controller
{

    public function indexAction(Request $request, $page)
    {
        
        $posts = $this->getDoctrine()->getEntityManager();
        $query = $posts->createQuery('
                SELECT p
                FROM AppBundle:Post p
                ORDER BY p.createdDate DESC
            ');
       
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $request->query->get('page', $page), 10);
        $pagination->setUsedRoute('_blog_index_paginated');
        return $this->render('blog/showPosts.html.twig', array(
            'posts' => $pagination,
            'delete_option' => false
        ));
    }

}
?>
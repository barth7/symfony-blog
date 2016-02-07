<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Post;

class BlogController extends Controller
{

    public function indexAction(Request $request, $page)
    {
        
        $posts = $this->getDoctrine()->getManager();
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
    public function findByTitleAction($slug){
        $posts = $this->getDoctrine()->getManager();
        $query = $posts->createQuery('
                SELECT p
                FROM AppBundle:Post p
                WHERE p.slug = :slug
            ');
        $query->setParameters(array(
            'slug' => $slug,
        ));
        $Post = $query->getResult();


        if(!empty($Post)){
            return $this->render('blog/showPost.html.twig', array(
                'post' => $Post[0],
                'delete_option' => false
            ));
        }else{
            return $this->redirectToRoute('_welcome');
        }

    }

}
?>
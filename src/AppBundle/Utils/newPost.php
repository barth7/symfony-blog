<?php
/**
 * Created by PhpStorm.
 * User: Bartek
 * Date: 06.02.2016
 * Time: 15:42
 */
namespace AppBundle\Utils;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;


class newPost
{
    protected $em;

    public function __construct(EntityManager   $em)
    {
        $this->em = $em;
    }

    public function newPost($newPost)
    {

        $this->em->persist($newPost);
        $this->em->flush();
        return new Response('Created New Post');
    }


}
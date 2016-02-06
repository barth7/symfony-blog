<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager){
        $post = new Post();
        $post->setTitle('test test');
        $post->setSlug('test-test');
        $post->setContent('przykladowy wpis');
        $post->setAuthor('bart');  
        
        $manager->persist($post);
        $manager->flush();
        
    }
}
?>
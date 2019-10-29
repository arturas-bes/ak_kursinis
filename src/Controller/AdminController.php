<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $blogPosts =  $em->getRepository(BlogPost::class)->findAll();
        $categories =  $em->getRepository(Category::class)->findAll();

        return $this->render('admin/base.html.twig', [
            'blog_posts' => $blogPosts,
            'categories' => $categories
        ]);
    }

}

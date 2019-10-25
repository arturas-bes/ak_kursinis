<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $blogPosts = 0;
        return $this->render('admin/base.html.twig', [
            'blog_posts' => $blogPosts,
        ]);
    }

    /**
     * @Route("/admin/blog-posts", name="blog_posts")
     */
    public function blogPosts()
    {
        $blogPosts = 0;
        return $this->render('admin/add_blog_post.html.twig', [
            'blog_posts' => $blogPosts,
        ]);
    }
}

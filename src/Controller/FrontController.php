<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Category $category
     * @param BlogPost $blogPost
     * @param User $user
     * @return Response
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $blogPosts =  $em->getRepository(BlogPost::class)->findAll();
        $categories =  $em->getRepository(Category::class)->findAll();

        return $this->render('front/index.html.twig', [
            'blog_posts' => $blogPosts,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/blog/{blogPost}", name="single_post")
     * @param $blogPost
     * @return Response
     */
    public function getSinglePost($blogPost)
    {   $em = $this->getDoctrine()->getManager();
        $singlePost =  $em->getRepository(BlogPost::class)->find($blogPost);

        return $this->render('front/single_post.html.twig',[
            'post' => $singlePost
        ]);
    }

    /**
     * @Route("/categories/{category_name}/{id}", name="category_posts")
     * @param $category_name
     * @return Response
     */
    public function getPostsbyCategory($category_name, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();
        $currentCategory =  $em->getRepository(Category::class)->find($id);
        $blogPosts =  $em->getRepository(BlogPost::class)->findBy(['category' => $currentCategory ]);

        return $this->render('front/filtered_posts.html.twig',[
            'categories' => $categories,
            'blog_posts' => $blogPosts,
            'current_category' => $currentCategory,
        ]);
    }
    /**
     * @Route("/about", name="about_admin")
     */
    public function aboutAdminPage()
    {
        return $this->render('front/about_admin.html.twig',[

        ]);
    }
    /**
     * @Route("/author/{id}", name="author_posts")
     * @return Response
     */
    public function getPostsByAuthor( $id)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository(Category::class)->findAll();
        $currentAuthor =  $em->getRepository(User::class)->find($id);
        $blogPosts =  $em->getRepository(BlogPost::class)->findBy(['author' => $currentAuthor ]);

        return $this->render('front/filtered_posts.html.twig',[
            'categories' => $categories,
            'blog_posts' => $blogPosts,
            'current_author' => $currentAuthor,
            'blog_posts_trim' => $blogPosts->getSubject(),
        ]);
    }
}
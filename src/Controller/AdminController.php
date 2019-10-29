<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\User;
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

    /**
     * @Route("/admin/users", name="users")
     */
    public function getAllusers()
    {
        $em = $this->getDoctrine()->getManager();
        $users =  $em->getRepository(User::class)->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/users/delete-user/{id}", name="delete_user")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('users');
    }
}

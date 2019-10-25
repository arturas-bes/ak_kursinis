<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/add-category", name="add_category")
     */
    public function addCategory()
    {

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/edit-category", name="edit_category")
     */
    public function editBlogPost()
    {

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/delete-post", name="delete_category")
     */
    public function deleteBlogPost()
    {

        return $this->redirectToRoute('admin');
    }
}

<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Form\BlogPostType;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/add-category", name="add_category")
     */
    public function addCategory(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category->setName($request->request->get('category')['name']);

            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('add_category');
        }


        return $this->render('admin/add_category.html.twig',[
            'form' => $form->createView(),
            'categories' => $this->getAllCategories(),
        ]);
    }
    public function getAllCategories()
    {
        $em = $this->getDoctrine()->getManager();
        $repo =  $em->getRepository(Category::class);

        return $repo->findAll();
    }

    /**
     * @Route("/admin/edit-category/{id}", name="edit_category", requirements={"id":"\d+"})
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editCategory(Category $category, Request $request)
    {

        $form = $this->createForm(CategoryType::class, $category);


        if ($this->saveCategory($category, $form, $request)) {

            return $this->redirectToRoute('add_category');
        }

        return $this->render('admin/edit_category.html.twig',[
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }
    private function saveCategory($category, $form, $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category->setName($request->request->get('category')['name']);
            $repo = $this->getDoctrine()->getRepository(Category::class);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return true;
        }
        return false;
    }
    /**
     * @Route("/admin/delete-category/{id}", name="delete_category", requirements={"id":"\d+"})
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCategory(Category $category)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('add_category');
    }

}

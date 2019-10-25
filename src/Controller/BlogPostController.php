<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\BlogPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Utilities\Uploader;

class BlogPostController extends AbstractController
{
    /**
     * @Route("/admin/add-post", name="add_blog_post")
     */
    public function addBlogPost(Request $request, Uploader $uploader)
    {
        $blogPost = new BlogPost();

        $form = $this->createForm(BlogPostType::class, $blogPost);

        if ($this->saveBlogPost($blogPost, $form, $request, $uploader)) {

            return $this->redirectToRoute('admin');

        }

        return $this->render('admin/add_blog_post.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/edit-post/{id}", name="edit_blog_post")
     */
    public function editBlogPost(BlogPost $blogPost, Request $request, Uploader $uploader)
    {
        $form = $this->createForm(BlogPostType::class, $blogPost);



        if ($this->saveBlogPost($blogPost, $form, $request, $uploader)) {

            return $this->redirectToRoute('admin');

        }
        return $this->render('admin/edit_blog_post.html.twig',[

            'blog_post' => $blogPost,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/admin/delete-post/{id}", name="delete_blog_post")
     */
    public function deleteBlogPost(BlogPost $blogPost)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($blogPost);
        $em->flush();

        return $this->redirectToRoute('admin');
    }

    /**
     * @param $blogPost
     * @param $form
     * @param $request
     * @param Uploader $uploader
     * @return bool
     */
    private function saveBlogPost($blogPost, $form, $request, $uploader)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogPost->setTitle($request->request->get('blog_post')['title']);

            $blogPost->setSubject($request->request->get('blog_post')['subject']);
            $file = $blogPost->getUploadedImage();

            $this->saveImage($blogPost, $file, $uploader);

            $repo = $this->getDoctrine()->getRepository(BlogPost::class);

            $em = $this->getDoctrine()->getManager();

            $em->persist($blogPost);
            $em->flush();

            return true;
        }
        return false;
    }

    private function saveImage($blogPost, $file, $uploader)
    {
        $basePath = BlogPost::blogPostImagesUploadFolder;
        $fileName = $uploader->upload($file);

        $blogPost->setImagePath($basePath.$fileName[0]);
        $blogPost->setImageTitle($fileName[1]);
    }
}

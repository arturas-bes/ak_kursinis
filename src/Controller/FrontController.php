<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('front/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }



    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param SessionInterface $session
     * @param $plan
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, SessionInterface $session)
    {
        $user = new User;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $user->setFirstName($request->request->get('user')['firstName']);
            $user->setLastName($request->request->get('user')['lastName']);
            $user->setEmail($request->request->get('user')['email']);

            $password = $encoder->encodePassword($user,
                $request->request->get('user')['password']['first']);
            $user->setPassword($password);

            $user->setRoles(['ROLE_USER']);

            $em->persist($user);
            $em->flush();

            $this->loginUserAutomatically($user, $password);
            return $this->redirectToRoute('admin');
        }

        return $this->render('front/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws \Exception
     * @Route("/logout", name="logout")
     */
    public function logout():void
    {
        throw new \Exception('This should never be reached!');
    }
    private function loginUserAutomatically($user, $password)
    {
        $token = new UsernamePasswordToken(
            $user,
            $password,
            'main',
            $user->getRoles()
        );
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
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
}
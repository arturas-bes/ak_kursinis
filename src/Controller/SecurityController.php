<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
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
            $this->saveUser($request, $user);
            $user->setRoles(['ROLE_USER']);

            $password = $encoder->encodePassword($user, $request->request->get('user')['password']['first']);
            $user->setPassword($password);
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
     * @Route("/admin/edit-user", name="edit_profile")
     */
    public function editUserProfile(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        $is_invalid = null;

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $this->saveUser($request, $user);
            $password = $encoder->encodePassword($user, $request->request->get('user')['password']['first']);
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/change_profile.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    private function saveUser($request, $user)
    {
        $user->setFirstName($request->request->get('user')['firstName']);
        $user->setLastName($request->request->get('user')['lastName']);
        $user->setEmail($request->request->get('user')['email']);
        $user->setAuthorDescription($request->request->get('user')['author_description']);
    }
}
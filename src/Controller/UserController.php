<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/admin/users", name="users")
     */
    public function users()
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/detail.html.twig', [
            'form_title' => 'Liste des utilisateurs',
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/addUser", name="addUser")
     */
    public function addUser(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder,
                            Request $request, GuardAuthenticatorHandler $guardHandler,
                            LoginFormAuthenticator $authenticator): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $user = new User();
        $userForm = $this->createForm(UserFormType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $userForm->get('plainPassword')->getData()
                )
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Votre nouvel utilisateur a bien été créé !");
            return $this->redirectToRoute('users', array('id' => $user->getId()));

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('user/ajouter.html.twig', [
            'form_title' => 'Créer un nouvel utilisateur',
            'userForm' => $userForm->createView()
        ]);
    }

}

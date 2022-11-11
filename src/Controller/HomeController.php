<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(UserRepository $user)
    {   
        $users = $user->findAll();
        return $this->render('Home/index.html.twig', [
            "users" => $users
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_edit")
     */
    public function edit(UserRepository $user, $id, EntityManagerInterface $manager, Request $request, UserPasswordHasherInterface $passwordHasher)
    {   
        $user = $user->find($id);
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() ) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('Home/edit.html.twig', [
            "user" => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_show")
     */
    public function show(UserRepository $user, $id)
    {   
        $user = $user->find($id);
        return $this->render('Home/show.html.twig', [
            "user" => $user,
        ]);
    }


    /**
     * @Route("/new", name="app_create")
     */
    public function new(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher)
    {   
        $user = new User();
        

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "modification enregister avec succès");

            return $this->redirectToRoute('app_login');
        }
        return $this->render('Home/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_delete")
     */
    public function delete(Request $request, User $user, $id, UserRepository $userRepository): Response
    {   
        if($this->isCsrfTokenValid('delete'.$user->getId(), $request->get('_token'))){
            $userRepository->remove($user, true);
        }
        return $this->redirectToRoute('app_home');
        
    }

    
}




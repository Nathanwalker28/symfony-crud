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
    public function edit(UserRepository $user, $id, EntityManagerInterface $manager, Request $request)
    {   
        $user = $user->find($id);
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() ) {
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
    public function new(Request $request, EntityManagerInterface $manager)
    {   
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('Home/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
}




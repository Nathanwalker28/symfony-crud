<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
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
    public function edit(UserRepository $user, $id)
    {   
        $user = $user->find($id);
        $form = $this->createForm(UserType::class, $user);
        return $this->renderForm('Home/edit.html.twig', [
            "user" => $user,
            'form' => $form
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

    
}




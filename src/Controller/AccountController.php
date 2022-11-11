<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/profil", name="app_account")
     * @IsGranted("ROLE_USER")
     * 
     */
    public function profil(): Response
    {
        $user = $this->getUser();
        return $this->render('account/index.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * @Route("/profil/edit/", name="app_account_edit")
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()) 
        {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "modification enregister avec succès");
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

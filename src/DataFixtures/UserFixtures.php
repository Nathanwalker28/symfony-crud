<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setLastname("prenom n° $i")
                ->setFirstname("prénom n° $i")
                ->setAdress("adresse n° $i")
                ->setTelephone("numero n° $i")
                ->setPassword("mot de passe n° $i");
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}

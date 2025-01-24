<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Picture;
use App\Entity\Reaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];

        // Créer des utilisateurs
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setUsername("User$i");
            
            // Hasher le mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword($user, "password$i");
            $user->setPassword($hashedPassword);
            
            // Définir les rôles
            $roles = ['ROLE_USER'];
            if ($i === 1) {
                $roles[] = 'ROLE_ADMIN';
            }
            $user->setRoles($roles);

            $manager->persist($user);
            $users[] = $user;
        }

        // Créer des photos
        $pictures = [];
        for ($i = 1; $i <= 10; $i++) {
            $picture = new Picture();
            $picture->setFilename("photo$i.jpg");
            $picture->setPath("/uploads/photos/photo$i.jpg");
            $manager->persist($picture);
            $pictures[] = $picture;
        }

        foreach ($pictures as $picture) {
            foreach ($users as $user) {
                $reaction = new Reaction();
                $reaction->setUser($user);
                $reaction->setPicture($picture);
                $reaction->setLikeReaction(rand(0, 1) === 1);
                $reaction->setDislikeReaction(rand(0, 1) === 0);
                $manager->persist($reaction);
            }
        }

        // Enregistrer toutes les entités
        $manager->flush();
    }
}
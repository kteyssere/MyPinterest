<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:hash-user-passwords')]
class HashUserPasswordsCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Hashes all non-hashed user passwords in the database.')
            ->setHelp('This command checks all users in the database and hashes their passwords if they are stored in plain text.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            // Corriger les rôles si nécessaire
            if (empty($user->getRoles())) {
                $user->setRoles(['ROLE_USER']);
                $output->writeln("Added ROLE_USER for user: {$user->getUsername()}");
            }

            // Vérifier si le mot de passe est déjà hashé
            if (!password_get_info($user->getPassword())['algo']) {
                $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);

                $output->writeln("Hashed password for user: {$user->getUsername()}");
            }
        }

        $this->entityManager->flush();

        $output->writeln('All non-hashed passwords have been hashed, and roles have been corrected.');
        return Command::SUCCESS;
    }

}
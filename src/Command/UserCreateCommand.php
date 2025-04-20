<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'app:user-create',
    description: 'Create test user',
)]
class UserCreateCommand extends Command
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = new User();
        $user->setEmail('user@example.com');
        $user->setPassword('string');


        $this->entityManager->persist($user);

        $this->entityManager->flush();
        $this->entityManager->clear();


        $this->entityManager->flush();
        $this->entityManager->clear();


        $io->success("User created successfully \n");

        print_r([
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);

        return Command::SUCCESS;
    }
}

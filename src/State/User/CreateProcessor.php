<?php

declare(strict_types=1);

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\User\UserResponse;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreateProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository,
    ) {}

    /**
     * @param User $data
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): UserResponse
    {
        if(!$data->getPassword())
        {
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }

        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPassword()
        );

        $data->setPassword($hashedPassword);
        $data->eraseCredentials();

        $user = new User();

        $user->setEmail($data->getEmail());
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user, true);

        return new UserResponse(
            $user->getId(),
            $user->getEmail(),
        );
    }

}
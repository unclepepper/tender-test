<?php

declare(strict_types=1);

namespace App\ApiResource\User;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


class UserRequest implements PasswordAuthenticatedUserInterface
{

    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['user:create'])]
    private string $email;

    #[Assert\NotBlank(groups: ['user:create'])]
    #[Groups(['user:create'])]
    private ?string $password = null;


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function eraseCredentials(): void
    {
        $this->password = null;
    }
}
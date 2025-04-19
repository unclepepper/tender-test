<?php

declare(strict_types=1);

namespace App\ApiResource\User;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\State\User\CreateProcessor;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/users',
            openapi: new Operation(
                responses: [
                    '201' => [
                        'description' => 'User created successfully',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                            'example' => '1',
                                        ],
                                        'email' => [
                                            'type' => 'string',
                                            'example' => 'user@example.com',
                                        ]
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ),
            shortName: 'User',
            processor: CreateProcessor::class
        ),
    ],
    denormalizationContext: ['groups' => ['user:create']]
)]
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
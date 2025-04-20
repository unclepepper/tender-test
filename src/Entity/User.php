<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\ApiResource\User\UserRequest;
use App\Repository\UserRepository;
use App\State\User\CreateProcessor;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
            input: UserRequest::class,
            processor: CreateProcessor::class
        ),
    ],
    denormalizationContext: ['groups' => ['user:create']]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;


    #[ORM\Column(length: 180, unique: true)]
    private string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 180)]
    private ?string $password;


    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @return list<string>
     * @see UserInterface
     *
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->password = null;
    }
}

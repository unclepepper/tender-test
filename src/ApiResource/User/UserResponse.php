<?php

declare(strict_types=1);

namespace App\ApiResource\User;

use JsonSerializable;

class UserResponse implements JsonSerializable
{
    public function __construct(
        private readonly ?int $id,
        private readonly ?string $email,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
        ];
    }
}
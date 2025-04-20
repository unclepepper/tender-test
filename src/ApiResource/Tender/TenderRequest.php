<?php

declare(strict_types=1);

namespace App\ApiResource\Tender;

use App\Enum\TenderStatusEnum;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


class TenderRequest
{
    private ?int $id = null;
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Groups(['tender:create'])]
    private string $title;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Groups(['tender:create'])]
    private string $number;

    #[Assert\Type('string')]
    #[Groups(['tender:create'])]
    private ?string $externalCode = null;

    #[Assert\NotBlank]
    #[Groups(['tender:create'])]
    private ?TenderStatusEnum $status = null;


    #[Groups(['tender:create'])]
    private ?DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;
        return $this;
    }

    public function getExternalCode(): ?string
    {
        return $this->externalCode;
    }

    public function setExternalCode(?string $externalCode): static
    {
        $this->externalCode = $externalCode;
        return $this;
    }

    public function getStatus(): ?TenderStatusEnum
    {
        return $this->status;
    }

    public function setStatus(?TenderStatusEnum $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}
<?php

declare(strict_types=1);

namespace App\ApiResource\Tender;

use App\Enum\TenderStatusEnum;
use DateTimeImmutable;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

readonly class TenderResponse implements JsonSerializable
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        private ?int $id,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        private string $title,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        private string $number,

        #[Assert\Type('string')]
        private ?string $externalCode = null,

        #[Assert\Type(TenderStatusEnum::class)]
        private ?TenderStatusEnum $status = null,

        private DateTimeImmutable $updatedAt
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getExternalCode(): ?string
    {
        return $this->externalCode;
    }

    public function getStatus(): TenderStatusEnum
    {
        return $this->status;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'number' => $this->getNumber(),
            'externalCode' => $this->getExternalCode(),
            'status' => $this->getStatus(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }
}
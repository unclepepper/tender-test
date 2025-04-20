<?php

namespace App\Entity;

use App\Enum\TenderStatusEnum;
use App\Repository\TenderRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TenderRepository::class)]
class Tender
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255, unique: true)]
    private string $number;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalCode = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, enumType: TenderStatusEnum::class)]
    private ?TenderStatusEnum $status = TenderStatusEnum::STATUS_CLOSE;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getNumber(): ?string
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

    public function getStatus(): TenderStatusEnum
    {
        return $this->status;
    }

    public function setStatus(?TenderStatusEnum $status): Tender
    {
        $this->status = $status;
        return $this;
    }

}

<?php

namespace App\Entity;


use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\RequestBody;
use App\ApiResource\Tender\TenderRequest;
use App\Enum\TenderStatusEnum;
use App\Filter\TenderStatusFilter;
use App\Repository\TenderRepository;
use App\State\Tender\CreateProcessor;
use ArrayObject;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(
    operations: [
        new Post(
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
                                            'example' => 0,
                                        ],
                                        'title' => [
                                            'type' => 'string',
                                            'example' => 'Лабороаторная посуда',
                                        ],
                                        'number' => [
                                            'type' => 'string',
                                            'example' => '17660-2',
                                        ],
                                        'externalCode' => [
                                            'type' => 'string',
                                            'example' => '152467180',
                                        ],
                                        'status' => [
                                            'type' => 'string',
                                            'example' => 'Открыто',
                                        ],
                                        'updatedAt' => [
                                            'type' => 'string',
                                            'example' => '2025-04-20T17:57:15.527Z',
                                        ]
                                    ]
                                ]
                            ],
                        ],
                    ],
                ],
                requestBody: new RequestBody(
                    content: new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'properties' => [
                                    'title' => [
                                        'type' => 'string',
                                        'example' => 'Лабороаторная посуда',
                                    ],
                                    'number' => [
                                        'type' => 'string',
                                        'example' => '17660-2',
                                    ],
                                    'externalCode' => [
                                        'type' => 'string',
                                        'example' => '152467180',
                                    ],
                                    'status' => [
                                        'type' => 'string',
                                        'example' => 'Открыто',
                                    ],
                                    'updatedAt' => [
                                        'type' => 'string',
                                        'example' => '2025-04-20T17:57:15.527Z',
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            ),
            input: TenderRequest::class,
            processor: CreateProcessor::class
        ),
        new GetCollection(),
        new Get(),
    ],

    normalizationContext: ['groups' => ['tender:read']],
    denormalizationContext: ['groups' => ['tender:create']],
)]
#[ApiFilter(TenderStatusFilter::class, properties: ['status' => 'exact'])]
#[ORM\Entity(repositoryClass: TenderRepository::class)]
class Tender
{

    #[Groups(['tender:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Groups(['tender:read'])]
    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private string $title;

    #[Groups(['tender:read'])]
    #[ORM\Column(length: 255, unique: true)]
    private string $number;

    #[Groups(['tender:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalCode = null;

    #[Groups(['tender:read'])]
    #[ORM\Column(type: 'string', length: 255, nullable: true, enumType: TenderStatusEnum::class)]
    private ?TenderStatusEnum $status = TenderStatusEnum::STATUS_CLOSE;

    #[Groups(['tender:read'])]
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private DateTimeImmutable $updatedAt;


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

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): Tender
    {
        if($updatedAt === null)
        {
            $updatedAt = new DateTimeImmutable();
        }

        $this->updatedAt = $updatedAt;
        return $this;
    }


}

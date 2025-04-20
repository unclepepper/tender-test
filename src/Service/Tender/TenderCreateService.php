<?php

declare(strict_types=1);

namespace App\Service\Tender;

use App\ApiResource\Tender\TenderResponse;
use App\Entity\Tender;
use Doctrine\ORM\EntityManagerInterface;

class TenderCreateService implements TenderCreateServiceInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    /**
     * @param mixed $data
     * @return TenderResponse|null
     */
    public function create(Tender $tender): ?TenderResponse
    {



        $this->entityManager->clear();
        $this->entityManager->persist($tender);
        $this->entityManager->flush();

        return new TenderResponse(
            $tender->getId(),
            $tender->getTitle(),
            $tender->getNumber(),
            $tender->getExternalCode(),
            $tender->getStatus(),
            $tender->getUpdatedAt()
        );
    }
}
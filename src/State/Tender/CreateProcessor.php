<?php

declare(strict_types=1);

namespace App\State\Tender;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Tender\TenderResponse;
use App\Entity\Tender;
use App\Service\Tender\TenderCreateServiceInterface;


final class CreateProcessor implements ProcessorInterface
{
    public function __construct(
        private TenderCreateServiceInterface $createService,

    ) {}

    /**
     * @param Tender $data
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): ?TenderResponse
    {

        $tender = new Tender();

        $tender->setTitle($data->getTitle());
        $tender->setNumber($data->getNumber());
        $tender->setExternalCode($data->getExternalCode());
        $tender->setStatus($data->getStatus());
        $tender->setUpdatedAt($data->getUpdatedAt());

        return $this->createService->create($tender);

    }


}
<?php

declare(strict_types=1);

namespace App\Service\Tender;

use App\ApiResource\Tender\TenderResponse;
use App\Entity\Tender;

interface TenderCreateServiceInterface
{
    public function create(Tender $tender): ?TenderResponse;
}
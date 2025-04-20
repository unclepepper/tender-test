<?php

declare(strict_types=1);

namespace App\Common\Parse;

interface ParseFileInterface
{
    /**
     * @param string $nameFile
     * @return array
     */
    public function parse(string $nameFile): array;
}

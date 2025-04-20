<?php

declare(strict_types=1);

namespace App\Common\Parse;

use Exception;
use Symfony\Component\HttpKernel\KernelInterface;


abstract class AbstractParseFile implements ParseFileInterface
{

    protected array $data;

    public function __construct(
        protected KernelInterface $kernel,
    ) {}

    /**
     * @return array<string, mixed>
     * @throws Exception
     */
    abstract public function parse(string $nameFile): array;

}

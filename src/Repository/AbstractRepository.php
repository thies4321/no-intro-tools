<?php

declare(strict_types=1);

namespace NoIntro\Repository;

use NoIntro\Service\DatParser;

abstract class AbstractRepository
{
    protected DatParser $datParser;

    public function __construct(?DatParser $datParser = null)
    {
        $this->datParser = $datParser ?? new DatParser();
    }

    abstract protected function buildArray(array $data): array;
}
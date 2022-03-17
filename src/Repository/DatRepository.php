<?php

declare(strict_types=1);

namespace NoIntro\Repository;

use NoIntro\Model\Dat;

interface DatRepository
{
    public function getByName(string $name): ?Dat;

    /**
     * @return Dat[]
     */
    public function findAll(): array;
}
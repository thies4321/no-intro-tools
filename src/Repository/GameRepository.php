<?php

declare(strict_types=1);

namespace NoIntro\Repository;

use NoIntro\Model\Dat;
use NoIntro\Model\Game;

interface GameRepository
{
    public function getByName(string $name): ?Game;

    /**
     * @return Game[]
     */
    public function findByDat(Dat $dat): array;
}
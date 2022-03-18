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
    public function findByName(string $name): array;

    /**
     * @return Game[]
     */
    public function findBySize(int $size): array;

    public function getByCrc(string $crc): ?Game;

    public function getByMd5(string $md5): ?Game;

    public function getBySha1(string $sha1): ?Game;

    public function getBySerial(string $serial): ?Game;

    /**
     * @return Game[]
     */
    public function findByStatus(string $status): array;

    /**
     * @return Game[]
     */
    public function findByDat(Dat $dat): array;
}

//$this->size = $size;
//$this->crc = $crc;
//$this->md5 = $md5;
//$this->sha1 = $sha1;
//$this->serial = $serial;
//$this->status = $status;
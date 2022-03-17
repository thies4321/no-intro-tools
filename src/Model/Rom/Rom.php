<?php

declare(strict_types=1);

namespace NoIntro\Model\Rom;

use NoIntro\Model\Rom as RomInterface;

final class Rom extends AbstractRom implements RomInterface
{
    public function __construct(
        string $name,
        int $size,
        string $crc,
        string $md5,
        string $sha1,
        ?string $serial = null,
        ?string $status = null
    ) {
        $this->name = $name;
        $this->size = $size;
        $this->crc = $crc;
        $this->md5 = $md5;
        $this->sha1 = $sha1;
        $this->serial = $serial;
        $this->status = $status;
    }
}
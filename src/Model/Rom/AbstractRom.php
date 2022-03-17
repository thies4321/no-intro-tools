<?php

namespace NoIntro\Model\Rom;

use NoIntro\Model\Rom;

abstract class AbstractRom implements Rom
{
    protected string $name;

    protected int $size;

    protected string $crc;

    protected string $md5;

    protected string $sha1;

    protected ?string $serial;

    protected ?string $status;

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getCrc(): string
    {
        return $this->crc;
    }

    public function getMd5(): string
    {
        return $this->md5;
    }

    public function getSha1(): string
    {
        return $this->sha1;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }
}
<?php

declare(strict_types=1);

namespace NoIntro\Model;

interface Rom
{
    public function getName(): string;

    public function getSize(): int;

    public function getCrc(): string;

    public function getMd5(): string;

    public function getSha1(): string;

    public function getSerial(): ?string;

    public function isVerified(): bool;
}
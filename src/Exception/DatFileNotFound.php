<?php

declare(strict_types=1);

namespace NoIntro\Exception;

use Exception;

use function sprintf;

final class DatFileNotFound extends Exception
{
    public static function forFileName(string $fileName): self
    {
        return new self(sprintf('.dat file not found for name [%s]', $fileName));
    }
}
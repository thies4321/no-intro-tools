<?php

declare(strict_types=1);

namespace NoIntro\Exception;

use Exception;
use NoIntro\Config\ErrorCodes;

use function sprintf;

final class DatFileNotFound extends Exception
{
    public static function forFileName(string $fileName): self
    {
        return new self(sprintf('.dat file not found for name [%s]', $fileName), ErrorCodes::DAT_NOT_FOUND_FOR_FILENAME);
    }
}
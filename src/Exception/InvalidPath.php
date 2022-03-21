<?php

declare(strict_types=1);

namespace NoIntro\Exception;

use Exception;
use NoIntro\Config\ErrorCodes;

use function sprintf;

final class InvalidPath extends Exception
{
    public static function forDirectory(string $path): self
    {
        return new self(sprintf('Path [%d] is not a directory', $path), ErrorCodes::INVALID_PATH_FOR_DIRECTORY);
    }

    public static function forFile(string $path): self
    {
        return new self(sprintf('File [%s] is not a file', $path), ErrorCodes::INVALID_PATH_FOR_FILE);
    }
}
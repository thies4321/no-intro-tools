<?php

declare(strict_types=1);

namespace NoIntro\Exception;

use Exception;
use function sprintf;

final class InvalidPath extends Exception
{
    public static function forDirectory(string $path): self
    {
        return new self(sprintf('Path [%d] is not a directory', $path));
    }
}
<?php

declare(strict_types=1);

namespace NoIntro\Service;

use NoIntro\Exception\DatFileNotFound;

use function file_exists;
use function file_get_contents;
use function json_decode;
use function json_encode;
use function simplexml_load_string;
use function sprintf;

final class DatParser
{
    public function parseDat(string $name): array
    {
        $filePath = sprintf('%s/../../resources/%s.dat', __DIR__, $name);

        if (! file_exists($filePath)) {
            throw DatFileNotFound::forFileName($name);
        }

        $fileContents = file_get_contents($filePath);

        return json_decode(
            json_encode(
                simplexml_load_string($fileContents, 'SimpleXMLElement', LIBXML_NOCDATA)
            ), true
        );
    }
}
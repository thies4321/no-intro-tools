<?php

declare(strict_types=1);

namespace NoIntro\Model\Dat;

use NoIntro\Model\Dat as DatInterface;

final class Dat extends AbstractDat implements DatInterface
{
    public function __construct(
        string $name,
        string $description,
        string $version,
        array $authors,
        string $homepage,
        string $url
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->version = $version;
        $this->authors = $authors;
        $this->homepage = $homepage;
        $this->url = $url;
    }

    public static function fromArray(array $dat)
    {
        return new self(
            $dat['name'],
            $dat['description'],
            $dat['version'],
            $dat['authors'],
            $dat['homepage'],
            $dat['url']
        );
    }
}
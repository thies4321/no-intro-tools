<?php

declare(strict_types=1);

namespace NoIntro\Model\Dat;

use NoIntro\Model\Dat;

abstract class AbstractDat implements Dat
{
    protected string $name;

    protected string $description;

    protected string $version;

    protected array $authors;

    protected string $homepage;

    protected string $url;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getHomepage(): string
    {
        return $this->homepage;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
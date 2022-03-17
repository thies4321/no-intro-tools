<?php

declare(strict_types=1);

namespace NoIntro\Model;

interface Dat
{
    public function getName(): string;

    public function getDescription(): string;

    public function getVersion(): string;

    public function getAuthors(): array;

    public function getHomepage(): string;

    public function getUrl(): string;
}
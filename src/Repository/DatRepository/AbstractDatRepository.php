<?php

namespace NoIntro\Repository\DatRepository;

use NoIntro\Model\Dat;
use NoIntro\Repository\DatRepository;
use NoIntro\Service\DatParser;

abstract class AbstractDatRepository implements DatRepository
{
    protected DatParser $datParser;

    public function __construct(?DatParser $datParser = null)
    {
        $this->datParser = $datParser ?? new DatParser();
    }

    protected function buildArray(array $data): array
    {
        $authors = explode(', ', $data['header']['author'] ?? '');

        return [
            'name' => $data['header']['name'] ?? '',
            'description' => $data['header']['description'] ?? '',
            'version' => $data['header']['version'] ?? '',
            'authors' => $authors,
            'homepage' => $data['header']['homepage'] ?? '',
            'url' => $data['header']['url'] ?? ''
        ];
    }

    abstract public function getByName(string $name): ?Dat;

    abstract public function findAll(): array;
}
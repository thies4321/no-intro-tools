<?php

declare(strict_types=1);

namespace NoIntro\Repository\DatRepository;

use NoIntro\Exception\DatFileNotFound;
use NoIntro\Model\Dat;
use NoIntro\Repository\AbstractRepository;
use NoIntro\Repository\DatRepository as DatRepositoryInterface;

use function explode;
use function file_exists;
use function in_array;
use function pathinfo;
use function scandir;
use function sprintf;

use const PATHINFO_FILENAME;

final class DatRepository extends AbstractRepository implements DatRepositoryInterface
{
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

    /**
     * @throws DatFileNotFound
     */
    public function getByName(string $name): ?Dat
    {
        $filePath = sprintf('%s/../../../resources/%s.dat', __DIR__, $name);

        if (! file_exists($filePath)) {
            return null;
        }

        $data = $this->datParser->parseDat($name);

        return Dat\Dat::fromArray($this->buildArray($data));
    }

    /**
     * @return Dat[]
     *
     * @throws DatFileNotFound
     */
    public function findAll(): array
    {
        $result = [];
        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $data = $this->datParser->parseDat(pathinfo($dat, PATHINFO_FILENAME));

            $result[] = Dat\Dat::fromArray($this->buildArray($data));
        }

        return $result;
    }
}
<?php

declare(strict_types=1);

namespace NoIntro\Repository\GameRepository;

use NoIntro\Exception\DatFileNotFound;
use NoIntro\Model\Dat;
use NoIntro\Model\Game;
use NoIntro\Model\Rom\Rom;
use NoIntro\Repository\AbstractRepository;
use NoIntro\Repository\DatRepository;
use NoIntro\Repository\GameRepository as GameRepositoryInterface;
use NoIntro\Service\DatParser;

use function file_exists;
use function in_array;
use function pathinfo;
use function scandir;
use function sprintf;

use const PATHINFO_FILENAME;

final class GameRepository extends AbstractRepository implements GameRepositoryInterface
{
    private DatRepository $datRepository;

    public function __construct(?DatParser $datParser = null, DatRepository $datRepository = null)
    {
        $this->datRepository = $datRepository ?? new DatRepository\DatRepository();

        parent::__construct($datParser);
    }

    protected function buildArray(array $data): array
    {
        return [
            'name' => $data['@attributes']['name'],
            'description' => $data['description'],
            'rom' => Rom::fromArray($data['rom']['@attributes']),
            'dat' => $data['dat']
        ];
    }

    /**
     * @throws DatFileNotFound
     */
    public function getByName(string $name): ?Game
    {
        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);
            $data = $this->datParser->parseDat($datName);
            $dat = $this->datRepository->getByName($datName);

            foreach ($data['game'] as $game) {
                if ($game['@attributes']['name'] === $name) {
                    $game['dat'] = $dat;

                    return Game\Game::fromArray($this->buildArray($game));
                }
            }
        }

        return null;
    }

    /**
     * @return Game[]
     *
     * @throws DatFileNotFound
     */
    public function findByName(string $name): array
    {
        $result = [];

        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);
            $data = $this->datParser->parseDat($datName);
            $dat = $this->datRepository->getByName($datName);

            foreach ($data['game'] as $game) {
                if ($game['@attributes']['name'] === $name) {
                    $game['dat'] = $dat;

                    $result[] = Game\Game::fromArray($this->buildArray($game));
                }
            }
        }

        return $result;
    }

    /**
     * @return Game[]
     *
     * @throws DatFileNotFound
     */
    public function findBySize(int $size): array
    {
        $result = [];

        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);
            $data = $this->datParser->parseDat($datName);
            $dat = $this->datRepository->getByName($datName);

            foreach ($data['game'] as $game) {
                if ($game['rom']['@attributes']['size'] === (string) $size) {
                    $game['dat'] = $dat;

                    $result[] = Game\Game::fromArray($this->buildArray($game));
                }
            }
        }

        return $result;
    }

    public function getByCrc(string $crc): ?Game
    {
        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);
            $data = $this->datParser->parseDat($datName);
            $dat = $this->datRepository->getByName($datName);

            foreach ($data['game'] as $game) {
                if ($game['rom']['@attributes']['crc'] === $crc) {
                    $game['dat'] = $dat;

                    return Game\Game::fromArray($this->buildArray($game));
                }
            }
        }

        return null;
    }

    public function getByMd5(string $md5): ?Game
    {
        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);
            $data = $this->datParser->parseDat($datName);
            $dat = $this->datRepository->getByName($datName);

            foreach ($data['game'] as $game) {
                if ($game['rom']['@attributes']['md5'] === $md5) {
                    $game['dat'] = $dat;

                    return Game\Game::fromArray($this->buildArray($game));
                }
            }
        }

        return null;
    }

    public function getBySha1(string $sha1): ?Game
    {
        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);
            $data = $this->datParser->parseDat($datName);
            $dat = $this->datRepository->getByName($datName);

            foreach ($data['game'] as $game) {
                if ($game['rom']['@attributes']['sha1'] === $sha1) {
                    $game['dat'] = $dat;

                    return Game\Game::fromArray($this->buildArray($game));
                }
            }
        }

        return null;
    }

    public function getBySerial(string $serial): ?Game
    {
        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);
            $data = $this->datParser->parseDat($datName);
            $dat = $this->datRepository->getByName($datName);

            foreach ($data['game'] as $game) {
                if (isset($game['rom']['@attributes']['serial']) && $game['rom']['@attributes']['serial'] === $serial) {
                    $game['dat'] = $dat;

                    return Game\Game::fromArray($this->buildArray($game));
                }
            }
        }

        return null;
    }

    public function findByStatus(string $status): array
    {
        $result = [];

        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);
            $data = $this->datParser->parseDat($datName);
            $dat = $this->datRepository->getByName($datName);

            foreach ($data['game'] as $game) {
                if (isset($game['rom']['@attributes']['status']) && $game['rom']['@attributes']['status'] === $status) {
                    $game['dat'] = $dat;

                    $result[] = Game\Game::fromArray($this->buildArray($game));
                }
            }
        }

        return $result;
    }

    /**
     * @return Game[]
     *
     * @throws DatFileNotFound
     */
    public function findByDat(Dat $dat): array
    {
        $filePath = sprintf('%s/../../../resources/%s.dat', __DIR__, $dat->getName());

        if (! file_exists($filePath)) {
            throw DatFileNotFound::forFileName($dat->getName());
        }

        $data = $this->datParser->parseDat($dat->getName());

        $result = [];

        foreach ($data['game'] as $game) {
            $game['dat'] = $dat;

            $result[] = Game\Game::fromArray($this->buildArray($game));
        }

        return $result;
    }
}

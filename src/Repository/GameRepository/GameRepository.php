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
        $dat = $this->datRepository->getByName($data['datName']);

        return [
            'name' => $data['@attributes']['name'],
            'description' => $data['description'],
            'rom' => Rom::fromArray($data['rom']['@attributes']),
            'dat' => $dat
        ];
    }

    public function getByName(string $name): ?Game
    {
        $dats = scandir(sprintf('%s/../../../resources', __DIR__));

        foreach ($dats as $dat) {
            if (in_array($dat, ['.', '..'])) {
                continue;
            }

            $datName = pathinfo($dat, PATHINFO_FILENAME);

            $data = $this->datParser->parseDat($datName);

            foreach ($data['game'] as $game) {
                if ($game['@attributes']['name'] === $name) {
                    $game['datName'] = $datName;

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
    public function findByDat(Dat $dat): array
    {
        $filePath = sprintf('%s/../../../resources/%s.dat', __DIR__, $dat->getName());

        if (! file_exists($filePath)) {
            throw DatFileNotFound::forFileName($dat->getName());
        }

        $data = $this->datParser->parseDat($dat->getName());

        $result = [];

        foreach ($data['game'] as $game) {
            $result[] = Game\Game::fromArray([
                'name' => $game['@attributes']['name'],
                'description' => $game['description'],
                'rom' => Rom::fromArray($game['rom']['@attributes']),
                'dat' => $dat
            ]);
        }

        return $result;
    }
}
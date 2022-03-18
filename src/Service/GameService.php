<?php

declare(strict_types=1);

namespace NoIntro\Service;

use NoIntro\Model\Game;
use NoIntro\Repository\DatRepository;
use NoIntro\Repository\GameRepository;
use function array_count_values;
use function array_merge;
use function count;
use function print_r;

final class GameService
{
    private GameRepository $gameRepository;

    private DatRepository $datRepository;

    public function __construct(GameRepository $gameRepository = null, DatRepository $datRepository = null)
    {
        $this->gameRepository = $gameRepository ?? new GameRepository\GameRepository();
        $this->datRepository = $datRepository ?? new DatRepository\DatRepository();
    }

    /**
     * @return Game[]
     */
    public function findGamesForOptions(array $options): array
    {
        $games = [];

        foreach ($options as $option => $value) {
            switch ($option) {
                case 'name':
                    $games[] = $this->gameRepository->getByName($value);
                    break;
                case 'size':
                    $games = array_merge($this->gameRepository->findBySize($value));
                    break;
                case 'crc':
                    $games[] = $this->gameRepository->getByCrc($value);
                    break;
                case 'md5':
                    $games[] = $this->gameRepository->getByMd5($value);
                    break;
                case 'sha1':
                    $games[] = $this->gameRepository->getBySha1($value);
                    break;
                case 'serial':
                    $games[] = $this->gameRepository->getBySerial($value);
                    break;
                case 'status':
                    $games = array_merge($games, $this->gameRepository->findByStatus($value));
                    break;
                case 'platform':
                    $dat = $this->datRepository->getByName($value);
                    $games = array_merge($games, $this->gameRepository->findByDat($dat));
                    break;
            }
        }

        if (count($options) < 2) {
            return $games;
        }

        $result = [];

        foreach ($games as $key => $game) {
            $i = 1;
            foreach ($games as $checkKey => $checkGame) {
                if ($key === $checkKey) {
                    continue;
                }

                if ($game->getName() === $checkGame->getName() && $game->getDat()->getName() === $checkGame->getDat()->getName()) {
                    $i++;
                }
            }

            if ($i > 1) {
                $result[] = $game;
            }
        }

        return $result;
    }
}
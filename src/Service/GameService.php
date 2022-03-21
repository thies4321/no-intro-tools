<?php

declare(strict_types=1);

namespace NoIntro\Service;

use NoIntro\Exception\InvalidPath;
use NoIntro\Model\Game;
use NoIntro\Repository\GameRepository;
use function dirname;
use function file_exists;
use function in_array;
use function is_dir;
use function rename;
use function scandir;
use function sha1_file;
use function sprintf;

final class GameService
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository = null)
    {
        $this->gameRepository = $gameRepository ?? new GameRepository\GameRepository();
    }

    /**
     * @throws InvalidPath
     */
    public function organiseDirectory(string $path, bool $commit = false): array
    {
        if (! is_dir($path)) {
            throw InvalidPath::forDirectory($path);
        }

        $files = scandir($path);

        $result = [
            'succes' => [],
            'failed' => []
        ];

        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $succes = $this->renameFile(sprintf('%s/%s', $path, $file), $commit);

            if ($succes === true) {
                $result['succes'][] = $file;
                continue;
            }

            $result['failed'][] = $file;
        }

        return $result;
    }

    /**
     * @throws InvalidPath
     */
    public function renameFile(string $path, bool $commit = false): bool
    {
        if (! file_exists($path)) {
            throw InvalidPath::forFile($path);
        }

        $sha1 = sha1_file($path);

        $game = $this->gameRepository->getBySha1($sha1);

        if (! $game instanceof Game) {
            return false;
        }

        $dirName = dirname($path);

        if ($commit === true) {
            rename($path, sprintf('%s/%s', $dirName, $game->getRom()->getName()));
        }

        return true;
    }
}
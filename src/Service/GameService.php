<?php

declare(strict_types=1);

namespace NoIntro\Service;

use NoIntro\Exception\InvalidPath;
use NoIntro\Repository\GameRepository;
use function is_dir;
use function scandir;

final class GameService
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository ?? new GameRepository\GameRepository();
    }

    public function organiseDirectory(string $path): array
    {
        if (! is_dir($path)) {
            throw InvalidPath::forDirectory($path);
        }

        $files = scandir($path);
    }

    public function renameFile(string $path): bool
    {

    }
}
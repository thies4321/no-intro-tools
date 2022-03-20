<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use NoIntro\Model\Game;
use NoIntro\Repository\GameRepository;
use Symfony\Component\Console\Command\Command;

use function max;
use function strlen;

abstract class GameCommand extends Command
{
    protected GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository = null)
    {
        $this->gameRepository = $gameRepository ?? new GameRepository\GameRepository();

        parent::__construct();
    }

    protected function getLongestFieldLengthForGame(Game $game): int
    {
        return max([
            strlen($game->getName()),
            strlen($game->getDescription()),
            strlen($game->getRom()->getName()),
            strlen($game->getRom()->getCrc()),
            strlen($game->getRom()->getMd5()),
            strlen($game->getRom()->getSha1()),
            strlen($game->getRom()->getSerial() ?? ''),
        ]);
    }
}
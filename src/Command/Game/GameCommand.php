<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use NoIntro\Model\Game;
use NoIntro\Repository\GameRepository;
use Symfony\Component\Console\Command\Command;

use function max;
use function sprintf;
use function strlen;

abstract class GameCommand extends Command
{
    protected GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository = null)
    {
        $this->gameRepository = $gameRepository ?? new GameRepository\GameRepository();

        parent::__construct();
    }
}
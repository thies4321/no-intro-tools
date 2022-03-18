<?php

declare(strict_types=1);

namespace NoIntro\Model\Game;

use NoIntro\Model\Dat;
use NoIntro\Model\Game as GameInterface;
use NoIntro\Model\Rom;

final class Game extends AbstractGame implements GameInterface
{
    public function __construct(string $name, string $description, Rom $rom, Dat $dat)
    {
        $this->name = $name;
        $this->description = $description;
        $this->rom = $rom;
        $this->dat = $dat;
    }

    public static function fromArray(array $game): self
    {
        return new self(
            $game['name'],
            $game['description'],
            $game['rom'],
            $game['dat']
        );
    }
}
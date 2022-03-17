<?php

declare(strict_types=1);

namespace NoIntro\Model\Game;

use NoIntro\Model\Game;
use NoIntro\Model\Rom;

abstract class AbstractGame implements Game
{
    protected string $name;

    protected string $description;

    protected Rom $rom;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getRom(): Rom
    {
        return $this->rom;
    }
}
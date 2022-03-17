<?php

declare(strict_types=1);

namespace NoIntro\Model;

interface Game
{
    public function getName(): string;

    public function getDescription(): string;

    public function getRom(): Rom;
}
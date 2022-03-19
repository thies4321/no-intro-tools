<?php

declare(strict_types=1);

namespace NoIntro\Command\Database;

use NoIntro\Repository\DatRepository;
use Symfony\Component\Console\Command\Command;

abstract class DatabaseCommand extends Command
{
    protected DatRepository $datRepository;

    public function __construct(DatRepository $datRepository = null)
    {
        $this->datRepository = $datRepository ?? new DatRepository\DatRepository();

        parent::__construct();
    }
}
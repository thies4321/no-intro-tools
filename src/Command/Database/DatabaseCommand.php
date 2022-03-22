<?php

declare(strict_types=1);

namespace NoIntro\Command\Database;

use NoIntro\Model\Dat;
use NoIntro\Repository\DatRepository;
use Symfony\Component\Console\Command\Command;

use function max;
use function strlen;

abstract class DatabaseCommand extends Command
{
    protected DatRepository $datRepository;

    public function __construct(DatRepository $datRepository = null)
    {
        $this->datRepository = $datRepository ?? new DatRepository\DatRepository();

        parent::__construct();
    }

    protected function getLongestFieldLengthForDat(Dat $dat): int
    {
        return max([
            strlen($dat->getName()),
            strlen($dat->getVersion()),
            strlen($dat->getHomepage()),
            strlen($dat->getUrl())
        ]);
    }
}
<?php

namespace NoIntro\Command;

use NoIntro\Repository\DatRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function sprintf;

#[AsCommand(
    name: 'database:list',
    description: 'List all no-intro databases',
    hidden: false
)]
final class ListDatabases extends Command
{
    private DatRepository $datRepository;

    public function __construct(DatRepository $datRepository = null)
    {
        $this->datRepository = $datRepository ?? new DatRepository\DatRepository();

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dats = $this->datRepository->findAll();
        $mask = "|%10.10s | %-30.30s |\n";

        foreach ($dats as $dat) {
            $output->writeln(sprintf('%s%s%s%s',
                sprintf($mask, 'Name', $dat->getName()),
                sprintf($mask, 'Version', $dat->getVersion()),
                sprintf($mask, 'Homepage', $dat->getHomepage()),
                sprintf($mask, 'Url', $dat->getUrl())
                )
            );
        }

        return Command::SUCCESS;
    }
}
<?php

declare(strict_types=1);

namespace NoIntro\Command\Database;

use NoIntro\Exception\DatFileNotFound;
use NoIntro\Repository\DatRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sprintf;

#[AsCommand(
    name: 'database:show',
    description: 'Show all no-intro databases',
    hidden: false
)]
final class Show extends DatabaseCommand
{
    /**
     * @throws DatFileNotFound
     */
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
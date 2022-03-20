<?php

declare(strict_types=1);

namespace NoIntro\Command\Database;

use NoIntro\Exception\DatFileNotFound;
use NoIntro\Model\Dat;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sprintf;
use function strlen;

#[AsCommand(
    name: 'database:get',
    description: 'Get database by name',
    hidden: false
)]
final class Get extends DatabaseCommand
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the database');
    }

    /**
     * @throws DatFileNotFound
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $dat = $this->datRepository->getByName($name);

        if (! $dat instanceof Dat) {
            $output->writeln(sprintf('<error>Database not found for name [%s]</error>', $name));
            return Command::FAILURE;
        }

        $lineLength = $this->getLongestFieldLengthForDat($dat);
        $mask = "| %8.8s | %-{$lineLength}.{$lineLength}s |\n";
        $output->writeln(sprintf('%s%s%s%s',
                sprintf($mask, 'Name', $dat->getName()),
                sprintf($mask, 'Version', $dat->getVersion()),
                sprintf($mask, 'Homepage', $dat->getHomepage()),
                sprintf($mask, 'Url', $dat->getUrl())
            )
        );

        return Command::SUCCESS;
    }
}
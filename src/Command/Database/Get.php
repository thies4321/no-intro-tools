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

#[AsCommand(
    name: 'database:get',
    description: 'Get database by name',
    hidden: false
)]
final class Get extends DatabaseCommand
{
    protected function configure()
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
            $output->writeln(sprintf('Database not found for name [%s]', $name));
        }

        $mask = "|%10.10s | %-30.30s |\n";
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
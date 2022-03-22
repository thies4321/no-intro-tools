<?php

declare(strict_types=1);

namespace NoIntro\Command\Database;

use NoIntro\Exception\DatFileNotFound;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
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

        if (empty($dats)) {
            $output->writeln('<error>No databases found</error>');
            return Command::FAILURE;
        }

        foreach ($dats as $dat) {
            $table = new Table($output);
            $table
                ->setHeaders(['Field', 'Value'])
                ->setRows([
                    ['Name', $dat->getName()],
                    ['Version', $dat->getVersion()],
                    ['Homepage', $dat->getHomepage()],
                    ['Url', $dat->getUrl()]
                ]);
            $table->render();
        }

        return Command::SUCCESS;
    }
}
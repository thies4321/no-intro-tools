<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use NoIntro\Model\Game;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sprintf;

#[AsCommand(
    name: 'game:get:name',
    description: 'Get game by name',
    hidden: false
)]
final class GetByName extends GameCommand
{
    public function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the game');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $game = $this->gameRepository->getByName($name);

        if (! $game instanceof Game) {
            $output->writeln(sprintf('<error>No game found for name [%s]</error>', $name));
            return Command::INVALID;
        }

        $table = new Table($output);
        $table
            ->setHeaders(['Field', 'Value'])
            ->setRows([
                ['Name', $game->getName()],
                ['Description', $game->getDescription()],
                ['Filename', $game->getRom()->getName()],
                ['CRC', $game->getRom()->getCrc()],
                ['MD5', $game->getRom()->getMd5()],
                ['SHA1', $game->getRom()->getSha1()],
                ['Serial', $game->getRom()->getSerial() ?? 'N/A'],
                ['Database', sprintf('%s (%s)', $game->getDat()->getName(), $game->getDat()->getVersion())]
            ]);

        $table->render();

        return Command::SUCCESS;
    }
}
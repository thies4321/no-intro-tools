<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function is_numeric;
use function sprintf;

#[AsCommand(
    name: 'game:find:size',
    description: 'Find games by size (bytes)',
    hidden: false
)]
final class FindBySize extends GameCommand
{
    public function configure(): void
    {
        $this->addArgument('size', InputArgument::REQUIRED, 'Storage size of the games in bytes');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $input = $input->getArgument('size');

        if (! is_numeric($input)) {
            $output->writeln('<error>Given size must be numeric</error>');
            return Command::INVALID;
        }

        $size = (int) $input;
        $games = $this->gameRepository->findBySize($size);

        if (empty($games)) {
            $output->writeln(sprintf('<error>No games found for size [%d]</error>', $size));
            return Command::INVALID;
        }

        foreach ($games as $game) {
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
        }

        return Command::SUCCESS;
    }
}
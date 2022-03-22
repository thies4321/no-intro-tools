<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sprintf;

#[AsCommand(
    name: 'game:show:verified',
    description: 'Get game by sha1 hash',
    hidden: false
)]
final class ShowVerified extends GameCommand
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $games = $this->gameRepository->findByStatus('verified');

        if (empty($games)) {
            $output->writeln('<error>No verified games found</error>');
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
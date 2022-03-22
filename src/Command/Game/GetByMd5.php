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
    name: 'game:get:md5',
    description: 'Get game by MD5 hash',
    hidden: false
)]
final class GetByMd5 extends GameCommand
{
    public function configure(): void
    {
        $this->addArgument('md5', InputArgument::REQUIRED, 'MD5 hash of the game');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $md5 = $input->getArgument('md5');
        $game = $this->gameRepository->getByMd5($md5);

        if (! $game instanceof Game) {
            $output->writeln(sprintf('<error>No game found for MD5 hash [%s]</error>', $md5));
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
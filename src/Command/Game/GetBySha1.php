<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use NoIntro\Model\Game;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sprintf;

#[AsCommand(
    name: 'game:get:sha1',
    description: 'Get game by sha1 hash',
    hidden: false
)]
final class GetBySha1 extends GameCommand
{
    public function configure(): void
    {
        $this->addArgument('sha1', InputArgument::REQUIRED, 'sha1 hash of the game');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $sha1 = $input->getArgument('sha1');
        $game = $this->gameRepository->getBySha1($sha1);

        if (! $game instanceof Game) {
            $output->writeln(sprintf('<error>No game found for sha1 hash [%s]</error>', $sha1));
            return Command::INVALID;
        }

        $lineLength = $this->getLongestFieldLengthForGame($game);
        $mask = "| %11.11s | %-{$lineLength}.{$lineLength}s |\n";

        $output->writeln(sprintf('%s%s%s%s%s%s%s%s%s',
                sprintf($mask, 'Name', $game->getName()),
                sprintf($mask, 'Description', $game->getDescription()),
                sprintf($mask, 'Filename', $game->getRom()->getName()),
                sprintf($mask, 'CRC', $game->getRom()->getCrc()),
                sprintf($mask, 'MD5', $game->getRom()->getMd5()),
                sprintf($mask, 'SHA1', $game->getRom()->getSha1()),
                sprintf($mask, 'Serial', $game->getRom()->getSerial() ?? 'N/A'),
                sprintf($mask, 'Verified', $game->getRom()->isVerified() ? 'True' : 'False'),
                sprintf($mask, 'Database', sprintf('%s (%s)', $game->getDat()->getName(), $game->getDat()->getVersion()))
            )
        );

        return Command::SUCCESS;
    }
}
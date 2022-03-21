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
    name: 'game:get:crc',
    description: 'Get game by crc checksum',
    hidden: false
)]
final class GetByCrc extends GameCommand
{
    public function configure(): void
    {
        $this->addArgument('crc', InputArgument::REQUIRED, 'Crc checksum of the game');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $crc = $input->getArgument('crc');
        $game = $this->gameRepository->getByCrc($crc);

        if (! $game instanceof Game) {
            $output->writeln(sprintf('<error>No game found for crc checksum [%s]</error>', $crc));
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
<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use NoIntro\Exception\DatFileNotFound;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sprintf;

#[AsCommand(
    name: 'game:find:name',
    description: 'Find games by name',
    hidden: false
)]
final class FindByName extends GameCommand
{
    public function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the game');
    }

    /**
     * @throws DatFileNotFound
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $games = $this->gameRepository->findByName($name);

        if (empty($games)) {
            $output->writeln(sprintf('<error>No games found for name [%s]</error>', $name));
            return Command::INVALID;
        }


        $lineLength = 0;

        foreach ($games as $game) {
            $checkLength = $this->getLongestFieldLengthForGame($game);

            if ($checkLength > $lineLength) {
                $lineLength = $checkLength;
            }
        }

        $mask = "| %11.11s | %-{$lineLength}.{$lineLength}s |\n";

        foreach ($games as $game) {
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
        }

        return Command::SUCCESS;
    }
}
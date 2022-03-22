<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use NoIntro\Exception\InvalidPath;
use NoIntro\Repository\GameRepository;
use NoIntro\Service\GameService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sleep;
use function sprintf;

#[AsCommand(
    name: 'game:rename:file',
    description: 'Rename file to matching database entry',
    hidden: false
)]
final class RenameFile extends GameCommand
{
    private GameService $gameService;

    public function __construct(
        GameService $gameService = null,
        GameRepository $gameRepository = null
    ) {
        $this->gameService = $gameService ?? new GameService();

        parent::__construct($gameRepository);
    }

    public function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'File to rename');
        $this->addArgument('commit', InputArgument::OPTIONAL, 'Commit renaming file', false);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');
        $commit = (bool) $input->getArgument('commit');

        if ($commit === false) {
            $output->writeln('<info>This is a test run. Provide commit to apply changes</info>');
        }

        if ($commit === true) {
            $output->writeln('<info>Commit supplied. Changes WILL apply. 5 seconds to cancel...</info>');
            sleep(5);
        }

        try {
            $success = $this->gameService->renameFile($path, $commit);
        } catch (InvalidPath $exception) {
            $output->writeln(sprintf('Could not find file for path [%s]', $path));
            return Command::FAILURE;
        }

        if ($success === true) {
            $output->writeln('Done!');
            return Command::SUCCESS;
        }

        $output->writeln('Renaming file failed');
        return Command::FAILURE;
    }
}
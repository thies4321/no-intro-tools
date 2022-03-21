<?php

declare(strict_types=1);

namespace NoIntro\Command\Game;

use NoIntro\Config\ErrorCodes;
use NoIntro\Exception\InvalidPath;
use NoIntro\Repository\GameRepository;
use NoIntro\Service\GameService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sleep;
use function sprintf;
use function ucfirst;

#[AsCommand(
    name: 'game:rename:directory',
    description: 'Find and replace files to match database entries in directory',
    hidden: false
)]
final class RenameDirectory extends GameCommand
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
        $this->addArgument('path', InputArgument::REQUIRED, 'Directory to find files and rename');
        $this->addArgument('commit', InputArgument::OPTIONAL, 'Commit renaming files', false);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');
        $commit = (bool) $input->getArgument('commit');

        if ($commit === true) {
            $output->writeln('<info>Commit supplied. Changes WILL apply. 5 seconds to cancel...</info>');
            sleep(5);
        }

        try {
            $result = $this->gameService->organiseDirectory($path, $commit);
        } catch (InvalidPath $exception) {
            switch ($exception->getCode()) {
                case ErrorCodes::INVALID_PATH_FOR_DIRECTORY:
                    $output->writeln(sprintf('<error>[%s] is not a valid directory</error>', $path));
                    break;
                case ErrorCodes::DAT_NOT_FOUND_FOR_FILENAME:
                    $output->writeln('<error>Something went wrong while renaming a file</error>');
            }

            return Command::FAILURE;
        }

        foreach ($result as $status => $files) {
            if (!empty($files)) {
                $output->writeln(sprintf('%s:', ucfirst($status)));

                foreach ($files as $file) {
                    $output->writeln($file);
                }

                echo PHP_EOL;
            }
        }

        return Command::SUCCESS;
    }
}
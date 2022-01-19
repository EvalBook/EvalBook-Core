<?php

namespace App\Command;

use App\Command\CommandUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'install-db',
    description: 'Install Database and migration',
)]
class InstallDbCommand extends Command
{
    /**
     * Define sf command options and args.
     */
    protected function configure(): void
    {
        $this
            ->addArgument('database_create', InputArgument::OPTIONAL, 'Create the database either not create it', 'y');
    }


    /**
     * Exec db install command.
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cmdr = true;

        // Creating the database if needed.
        if (strtolower($input->getArgument('database_create')) === 'y') {
            $cmdr = $this->exec($io, 'php bin/console doctrine:database:create', [
                'intro' => 'Installing database',
                'success' => 'Database was created',
                'error' => 'An error occurred while creating the database',
            ]);
        }

        if ($cmdr) {
            $cmdr = $this->exec($io, 'php bin/console doctrine:migrations:migrate --no-interaction', [
                'intro' => 'Pushing migration',
                'success' => 'Database was populated',
                'error' => 'An error occurred while populating the database',
            ]);
        }

        return $cmdr ? Command::SUCCESS : Command::FAILURE;
    }


    /**
     * @param SymfonyStyle $io
     * @param string $cmd
     * @param array $msgs
     * @return bool
     */
    private function exec(SymfonyStyle $io, string $cmd, array $msgs): bool {
        $io->info($msgs['intro'] ?? "Executing new command");
        $cmdr = CommandUtil::execSymfonyCmd($cmd);

        if($cmdr) {
            $io->success($msgs['success'] ?? "The provided command was executed");
        }
        else {
            $io->error($msgs['error'] ?? "An error occurred while executing the last command");
        }

        return $cmdr;
    }
}
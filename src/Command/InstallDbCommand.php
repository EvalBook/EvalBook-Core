<?php

namespace EvalBookCore\Command;

use EvalBookCore\Command\CommandUtil;
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
            $messages = [
                'Installing database',
                'Database was created',
                'An error occurred while creating the database',
            ];

            $cmdr = $this->exec($io, 'php bin/console doctrine:database:create', $messages);
        }

        if ($cmdr) {
            $messages = [
                'Creating migration',
                'Migration created',
                'An error occurred while creating migration',
            ];

            // Deleting migrations if any.
            $io->info('Checking for existing migrations');
            $files = glob(__DIR__ . '/../../migrations/*.php');
            foreach($files as $file) {
                if(is_file($file)) {
                    $io->info("Deleting migration: $file");
                    unlink($file);
                    $io->info("...Deleted");
                }
            }

            // Starting building new migration
            $cmdr = $this->exec($io, 'php bin/console make:migration --no-interaction', $messages);
        }


        if ($cmdr) {
            $messages = [
                'Pushing migration',
                'Database was populated',
                'An error occurred while populating the database',
            ];

            $cmdr = $this->exec($io, 'php bin/console doctrine:migrations:migrate --no-interaction', $messages);
        }

        return $cmdr ? Command::SUCCESS : Command::FAILURE;
    }


    /**
     * @param SymfonyStyle $io
     * @param string $cmd
     * @param array $msgs
     * @return bool
     */
    private function exec(SymfonyStyle $io, string $cmd, array $msgs): bool
    {
        $io->info($msgs[0]);
        $cmdr = CommandUtil::execSymfonyCmd($cmd);
        list($f, $p) = $cmd ? ['success', $msgs[1]] : ['error', $msgs[2]];
        $io->$f($p);
        return $cmdr;
    }
}
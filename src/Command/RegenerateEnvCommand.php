<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'regenerate-env',
    description: 'Generate a .env file base on provided environnement',
)]
class RegenerateEnvCommand extends Command
{

    /**
     * Command configuration, specifying console argv.
     */
    protected function configure(): void
    {
        $this->addArgument('env', InputArgument::REQUIRED, 'The desired environnement for .env generation');
        $this->addArgument('db_dsn', InputArgument::REQUIRED, 'The database connexion DSN');
    }

    /**
     * Execute.
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $env = $input->getArgument('env');
        $dbDsn = $input->getArgument('db_dsn');

        // Checking env file environnement.
        if(!in_array($env, ['prod', 'dev'])) {
            $io->error("Environnement should be \"dev\" or \"prod\"");
            exit(1);
        }

        // Checking dsn.
        if(!preg_match("#[a-zA-Z]*:\/\/\S*:\S*@\S*:\d*\/\S*#", $dbDsn)) {
            $io->error("The provided database DSN does not match the dsn pattern");
        }

        // Processing env file.
        $file = $env === 'prod' ? ".env" : ".env.local";
        $proceed = true;

        if(is_file($file)) {
            $proceed = unlink($file);
        }

        if(!$proceed) {
            $io->error("Unable to delete old \"$file\" file, please delete it manually and try again");
            exit(1);
        }

        $io->note("New env file created");
        $io->note(sprintf('Generating .env file for environnement: %s', $env));

        // Generating app secret.
        $env_data = "APP_ENV=$env\nAPP_SECRET=";
        for ($i = 0; $i < 32; $i++) {
            $env_data .= '0123456789abcdef'[rand(0, 15)];
        }

        $io->note("Storing APP_ENV and APP_SECRET");
        file_put_contents($file, $env_data . "\n", FILE_APPEND);

        // Generating databse dsn.
        $io->note("Storing Database dsn");
        file_put_contents($file, 'DATABASE_URL=' . "\"$dbDsn\"", FILE_APPEND);

        // Generating app secret.
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}

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
     * Command confirguration, specifying console argvs.
     */
    protected function configure(): void
    {
        $this->addArgument('env', InputArgument::REQUIRED, 'The desired environnement for .env generation');
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

        if(in_array($env, ['prod', 'dev'])) {
            $io->note(sprintf('Generating .env file for environnement: %s', $env));
        }
        else {
            $io->error("Environnement should be \"dev\" or \"prod\"");
            exit(1);
        }

        // Processing env file.
        $file = $env === 'prod' ? ".env" : ".env.local";
        $proceed = true;

        if(is_file($file)) {
            $proceed = unlink($file);
        }

        if($proceed) {
            // Generating app secret.
            $env_data = "APP_ENV=$env\nAPP_SECRET=";
            for ($i = 0; $i < 32; $i++) {
                $env_data .= '0123456789abcdef'[rand(0, 15)];
            }

            file_put_contents($file, $env_data);
            // Pushing data into a new env file.
        }
        else {
            $io->error("Unable to delete old \"$file\" file, please delete it manually and try again");
            exit(1);
        }

        // Generating app secret.
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}

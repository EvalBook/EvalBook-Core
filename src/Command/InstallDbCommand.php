<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Command\CommandUtil;


#[AsCommand(
    name: 'InstallDb',
    description: 'Install Database and migration',
)]
class InstallDbCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('database_create', InputArgument::REQUIRED, 'Create the database either not create it', 'y')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $createDatabase = strtolower($input->getArgument('database_create'));


        return Command::SUCCESS;
    }
}

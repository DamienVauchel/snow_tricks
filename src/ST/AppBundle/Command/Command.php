<?php
namespace ST\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('premier:test')
            ->setDescription('ceci est un premier test')
            ->addArgument('date', InputArgument::OPTIONAL, 'Date du jour');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = $input->getArgument('date');

        $output->writeln($date);
    }
}
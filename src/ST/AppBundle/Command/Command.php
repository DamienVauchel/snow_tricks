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
            ->setDescription('ceci est un premier test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $value = Yaml::parse(file_get_contents(__DIR__."/../../../../app/config/tricks.yml", true));
//        $value = exec("ls ../");
//        die(var_dump(scandir(__DIR__."/../../../../app/config/tricks.yml")));
        dump($value);

        foreach($value as $item)
        {
            $trick = new Trick();
            $trick->setTitle($item['title']);

            $em->persist($trick);


        }
        $em->flush();
    }
}
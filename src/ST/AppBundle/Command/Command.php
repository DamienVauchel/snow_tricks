<?php
namespace ST\AppBundle\Command;

use ST\AppBundle\Entity\Category;
use ST\AppBundle\Entity\Image;
use ST\AppBundle\Entity\Trick;
use ST\AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('st:datas')
            ->setDescription('Rempli la base de données avec des données d\'exemple');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $categories = Yaml::parse(file_get_contents(__DIR__."/../../../../app/config/categories.yml", true));
        $tricks = Yaml::parse(file_get_contents(__DIR__."/../../../../app/config/tricks.yml", true));
        $images = Yaml::parse(file_get_contents(__DIR__."/../../../../app/config/images.yml", true));

        foreach($categories as $item)
        {
            $category = new Category();
            $category->setName($item['title']);

            $em->persist($category);
        }
        $em->flush();

        foreach($tricks as $item)
        {
            $trick = new Trick();
            $trick->setTitle($item['title']);
            $trick->setDescription($item['description']);
            $trick->setLevel($item['level']);
            $trick->setAuthor($item['author']);
            $category_slug = $item['category_slug'];
            $category = $em->getRepository('STAppBundle:Category')->findBySlug($category_slug);
            $trick->setCategory($category);
            $trick->setCreationDate(new \DateTime());

            $em->persist($trick);
        }
        $em->flush();

        foreach($images as $item)
        {
            $image = new Image();
            $image->setExtension($item['extension']);
            $image->setAlt($item['alt']);
            $trick_slug = $item['trick_slug'];
            $trick = $em->getRepository('STAppBundle:Trick')->findBySlug($trick_slug);
            $image->setTrick($trick);

            $em->persist($image);
        }
        $em->flush();

        $output->writeln("Your datas have been succefully added to database");
    }
}
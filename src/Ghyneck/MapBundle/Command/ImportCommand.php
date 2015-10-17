<?php

namespace Ghyneck\MapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('map:import')
            ->setDescription('Import Images and Gpx Files from directory')
            ->addArgument(
                'directory',
                InputArgument::OPTIONAL,
                'Which directory do you want to import?'
            )
            ->addOption(
                'all',
                null,
                InputOption::VALUE_NONE,
                'If set, the directory argument will be ignored and all diretories will be imported.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $uploadDestination = $this->getUploadDestination();

        if ($input->getOption('all')) {
            $this->importAllDirectories($uploadDestination);
            $output->writeln("All directories imported.");
            return;
        }

        $directory = $input->getArgument('directory');
        if ($directory) {
            $this->importDirectory($uploadDestination, $directory);
            $output->writeln("Directory $directory imported.");
        } else {
            $output->writeln("No directories imported.");
        }
    }

    protected function getUploadDestination()
    {
        $vichUploaderMappings = $this->getContainer()->getParameter('vich_uploader.mappings');
        $uploadDestination = $vichUploaderMappings['image']['upload_destination'];
        return $uploadDestination;
    }

    protected function importAllDirectories($uploadDestination)
    {

    }

    protected function importDirectory($uploadDestination, $directory)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $tour = $em->getRepository('MapBundle:Tour')->findOneByDirectory($directory);
        // tour-addImages
        // tour->setGpxFile
    }
}
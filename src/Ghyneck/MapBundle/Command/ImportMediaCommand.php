<?php

namespace Ghyneck\MapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ghyneck\MapBundle\Helper\DiariesFolder;


class ImportMediaCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('map:import:media')
            ->setName('map:import:media')
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
            $this->importDirectory($directory);
            $output->writeln("Directory $directory imported.");
        } else {
            $output->writeln("Please specify a directory as argument or set --all to import all directories.");
        }
    }

    /*
     * @return string
     */
    protected function getUploadDestination()
    {
        $vichUploaderMappings = $this->getContainer()->getParameter('vich_uploader.mappings');
        $uploadDestination = $vichUploaderMappings['image']['upload_destination'];
        return $uploadDestination;
    }

    /*
     * @param string $uploadDestination
     */
    protected function importAllDirectories($uploadDestination)
    {
        $diariesFolder = new DiariesFolder($uploadDestination);
        $subDirectories = $diariesFolder->getDiaryFolders();
        foreach ($subDirectories as $subDirectory){
            $this->importDirectory($subDirectory->getRelativePathname());
        }

    }

    /*
     * @param string $uploadDestination
     * @param string $directory which directory to choose from all directories within $uploadDestination
     */
    protected function importDirectory($directory)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $tour = $em->getRepository('MapBundle:Tour')->findOneByDirectory($directory);

        /** @var Ghyneck\MapBundle\Service\FileImporter $fileImporter */
        $fileImporter = $this->getContainer()->get('fileImporter');
        $fileImporter->assignFilesToTour($tour);

        $em->persist($tour);
        $em->flush();
    }

}
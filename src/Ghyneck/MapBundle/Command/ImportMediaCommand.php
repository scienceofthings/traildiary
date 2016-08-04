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

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try{
            $this->importMedia($input);
            $output->writeln("Media was imported.");
        } catch (\InvalidArgumentException $exception){
            $output->writeln($exception->getMessage());
        }
    }

    /**
     * @param InputInterface $input
     *
     * @throws \InvalidArgumentExceptiongit f
     */
    private function importMedia(InputInterface $input)
    {
        $uploadDestination = $this->getUploadDestination();

        if ($input->getOption('all')) {
            $this->importAllDirectories($uploadDestination);
        }

        $directory = $input->getArgument('directory');
        if (is_string($directory) && !empty($directory)) {
            $this->importDirectory($directory);
        } else {
            throw new \InvalidArgumentException(
                "Please specify a directory basepath (e.g. 'php app/console myTrail') as argument or " .
                "set --all to import all directories."
            );
        }
    }

    /*
     * @return string The upload folder from the configuration
     */
    protected function getUploadDestination()
    {
        $vichUploaderMappings = $this->getContainer()->getParameter('vich_uploader.mappings');
        $uploadDestination = $vichUploaderMappings['image']['upload_destination'];
        if(!is_string($uploadDestination) || $uploadDestination === ''){
            return '';
        }
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

    /**
     * @param string $directory which directory to choose from all directories within $uploadDestination
     *
     * @throws \InvalidArgumentException When the specified directory does not exist
     */
    protected function importDirectory($directory)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $tour = $em->getRepository('MapBundle:Tour')->findOneByDirectory($directory);

        if($tour === null){
            throw new \InvalidArgumentException('There is no tour associated with this directory.');
        }

        /** @var Ghyneck\MapBundle\Service\FileImporter $fileImporter */
        $fileImporter = $this->getContainer()->get('fileImporter');
        $fileImporter->assignFilesToTour($tour);

        $em->persist($tour);
        $em->flush();
    }
}
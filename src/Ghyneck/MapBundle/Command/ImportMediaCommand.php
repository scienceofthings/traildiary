<?php

namespace Ghyneck\MapBundle\Command;

use Ghyneck\MapBundle\Entity\Tour;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ghyneck\MapBundle\Helper\DiaryFolder;
use Ghyneck\MapBundle\Entity\TourImage;

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
            $this->importDirectory($uploadDestination, $directory);
            $output->writeln("Directory $directory imported.");
        } else {
            $output->writeln("No directories imported.");
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

    protected function importAllDirectories($uploadDestination)
    {

    }

    /*
     * @param string $uploadDestination
     * @param string $directory which directory to choose from all directories within $uploadDestination
     */
    protected function importDirectory($uploadDestination, $directory)
    {
        $diaryFolder = new DiaryFolder($uploadDestination, $directory);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $tour = $em->getRepository('MapBundle:Tour')->findOneByDirectory($directory);
        if($tour instanceof Tour){
            $this->addTourImages($tour, $diaryFolder, $directory);
            $this->addGpxFile($tour, $diaryFolder, $directory);
            $em->persist($tour);
        }
        $em->flush();
    }

    /*
     * @param Tour $tour
     * @param DiaryFolder $diaryFolder
     * @param string $prefix
     */
    protected function addGpxFile($tour, $diaryFolder, $directory)
    {
        $gpxFile = $diaryFolder->getGpxFile();
        $tour->setGpxFileName($directory . DIRECTORY_SEPARATOR . $gpxFile);

    }

    /*
     * @param Tour $tour
     * @param DiaryFolder $diaryFolder
     * @param string $prefix
     */
    protected function addTourImages(Tour $tour, DiaryFolder $diaryFolder, $prefix)
    {
        $this->removeTourImages($tour);
        $images = $diaryFolder->getImageFiles();
        foreach($images as $image){
            $tourImage = new TourImage();
            $tourImage->setFileName($prefix . DIRECTORY_SEPARATOR . $image->getFilename());
            $tour->addImage($tourImage);
        }


    }

    /*
     * @param Tour $tour
     */
    protected function removeTourImages(Tour $tour)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $tourImages = $tour->getTourImages()->toArray();
        foreach($tourImages as $tourImage){
            $em->remove($tourImage);
        }
        $em->flush();
    }


}
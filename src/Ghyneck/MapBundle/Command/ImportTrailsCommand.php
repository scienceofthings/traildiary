<?php

namespace Ghyneck\MapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\SplFileInfo;
use Ghyneck\MapBundle\Helper\DiariesFolder;
use Ghyneck\MapBundle\Helper\DescriptionFile;
use Ghyneck\MapBundle\Entity\Tour;
use Ghyneck\MapBundle\Helper\DiaryFolder;

class ImportTrailsCommand extends ContainerAwareCommand
{

    /*
     * @var string
     */
    private $uploadDestination;

    protected function configure()
    {
        $this
            ->setName('trails:import')
            ->setDescription('Import diary from description.md files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setUploadDestination();
        $this->importAllDirectories();
        $output->writeln("All directories imported.");
        return;
    }

    /*
     * @return string
     */
    protected function setUploadDestination()
    {
        $vichUploaderMappings = $this->getContainer()->getParameter('vich_uploader.mappings');
        $this->uploadDestination = $vichUploaderMappings['image']['upload_destination'];
    }

    protected function importAllDirectories()
    {
        $diariesFolder = new DiariesFolder($this->uploadDestination);
        $diaryFolders = $diariesFolder->getDiaryFolders();
        foreach($diaryFolders as $diaryFolder){
            $this->importDirectory($diaryFolder);
        }
    }

    /*
     * @param Finder $diaryFolder
     */
    protected function importDirectory(SplFileInfo $diaryFolderFinder)
    {
        $diaryFolder = new DiaryFolder($diaryFolderFinder);
        $tour = new Tour();
        $tour->setTitle($diaryFolderFinder->getRelativePathname());
        $tour->setDirectory($diaryFolderFinder->getRelativePathname());
        $descriptionFile = new DescriptionFile($diaryFolder->getDescriptionFile());
        $tour->setDescription($descriptionFile->getDescriptionAsHtml());

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($tour);
        $em->flush();
    }



}
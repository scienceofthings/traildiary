<?php
namespace Ghyneck\MapBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ghyneck\MapBundle\Entity\Tour;
use Ghyneck\MapBundle\Entity\TourImage;



class FileImporter
{
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $tour = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($tour instanceof Tour) {
            $this->assignFilesToTour($tour);
        }
    }

    public function assignFilesToTour($tour)
    {
        $diaryPageFolderPath = $this->getUploadDirectoryPath() . DIRECTORY_SEPARATOR . $tour->getDirectory();
        if(is_dir($diaryPageFolderPath) === true){
            $this->assignGpxFiles($tour, $diaryPageFolderPath);
            $this->assignTourImages($tour, $diaryPageFolderPath);
        }
    }

    /*
     * @param Ghyneck\MapBundle\Entity\Tour $tour
     * @param string $diaryPageFolderPath
     */
    protected function assignGpxFiles($tour, $diaryPageFolderPath)
    {
        $diaryPageFolderIterator = new \DirectoryIterator($diaryPageFolderPath);
        $gpxFiles = new \RegexIterator($diaryPageFolderIterator, '/\.gpx$/');
        foreach($gpxFiles as $gpxFile){
            $fileNameOfGpxFile = $gpxFile->getFilename();
            $tour->setGpxFileName($tour->getDirectory() . DIRECTORY_SEPARATOR. $fileNameOfGpxFile);
        }
    }

    /*
    * @param Ghyneck\MapBundle\Entity\Tour $tour
    * @param string $diaryPageFolderPath
    */
    protected function assignTourImages($tour, $diaryPageFolderPath)
    {
        $directory = new \DirectoryIterator($diaryPageFolderPath);
        $imageFileIterator = new \RegexIterator($directory, '/\.jpe?g$/i');
        foreach($imageFileIterator as $imageFile){
            $tourImage = new TourImage();
            $tourImage->setFileName($tour->getDirectory() . DIRECTORY_SEPARATOR. $imageFile->getFilename());
            $tour->addImage($tourImage);
        }
    }


    protected function getUploadDirectoryPath()
    {
        $vichUploaderMappings = $this->container->getParameter('vich_uploader.mappings');
        $uploadDestination = $vichUploaderMappings['image']['upload_destination'];
        return $uploadDestination;
    }


}
<?php
namespace Ghyneck\MapBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ghyneck\MapBundle\Entity\Tour;
use Ghyneck\MapBundle\Entity\TourImage;
use \Ghyneck\MapBundle\Helper\DiaryFolder;
use \Ghyneck\MapBundle\Helper\GpxFile;


class FileImporter
{
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $tour = $args->getEntity();

        if ($tour instanceof Tour) {
            $this->assignFilesToTour($tour);
        }
    }

    /*
     * @param Tour $tour
     */
    public function assignFilesToTour(Tour $tour)
    {
        $uploadDestination = $this->getUploadDestination();
        $diaryFolderInfo = new \SplFileInfo($uploadDestination . DIRECTORY_SEPARATOR . $tour->getDirectory());
        $diaryFolder = new DiaryFolder($diaryFolderInfo);
        $this->addTourImages($tour, $diaryFolder, $tour->getDirectory());
        $this->setGpsInformation($tour, $diaryFolder);
    }

    /*
     * @return string
     */
    protected function getUploadDestination()
    {
        $vichUploaderMappings = $this->container->getParameter('vich_uploader.mappings');
        $uploadDestination = $vichUploaderMappings['image']['upload_destination'];
        return $uploadDestination;
    }

    /*
 * @param Tour $tour
 * @param DiaryFolder $diaryFolder
 */
    protected function setGpsInformation(Tour $tour, DiaryFolder $diaryFolder)
    {
        $gpxFileInfo = $diaryFolder->getGpxFile();
        if($gpxFileInfo === null){
            return;
        }
        $gpxFile = new GpxFile($gpxFileInfo);
        $tour->setGpxFileName($gpxFile->getPathNameRelativeToUploads());
        $tour->setMarkerlat($gpxFile->getLattitude());
        $tour->setMarkerlon($gpxFile->getLongitude());
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
        $em = $this->container->get('doctrine')->getManager();
        $tourImages = $tour->getTourImages()->toArray();
        foreach($tourImages as $tourImage){
            $em->remove($tourImage);
        }
        $em->flush();
    }







}
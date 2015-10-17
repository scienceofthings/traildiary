<?php

namespace Ghyneck\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Tour
 */
class Tour
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $directory;

    /**
     * @var string
     */
    private $gpxFileName;

    /*
     * @var File
     */
    private $gpxFile;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $tourImages;

    /**
     * @var float
     */
    private $markerlat;

    /**
     * @var float
     */
    private $markerlon;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tourImages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Tour
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Tour
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set directory
     *
     * @param string $directory
     * @return Tour
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Get directory
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Set gpxFile
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $gpxFile
     */     
    public function setGpxFile($gpxFile)
    {
        $this->gpxFile = $gpxFile;
        if($gpxFile){
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * Get gpxFile
     *
     * @return Gpxfile
     */
    public function getGpxFile()
    {
        return $this->gpxFile;
    }

    /*
     * @param string $gpxFileName
     */
    public function setGpxFileName($gpxFileName)
    {
        $this->gpxFileName = $gpxFileName;
    }

    /*
     * @return string
     */
    public function getGpxFileName()
    {
        return $this->gpxFileName;
    }

    /**
     * Set markerlat
     *
     * @param float $markerlat
     * @return Tour
     */
    public function setMarkerlat($markerlat)
    {
        $this->markerlat = $markerlat;

        return $this;
    }

    /**
     * Get markerlat
     *
     * @return float 
     */
    public function getMarkerlat()
    {
        return $this->markerlat;
    }

    /**
     * Set markerlon
     *
     * @param float $markerlon
     * @return Tour
     */
    public function setMarkerlon($markerlon)
    {
        $this->markerlon = $markerlon;

        return $this;
    }

    /**
     * Get markerlon
     *
     * @return float 
     */
    public function getMarkerlon()
    {
        return $this->markerlon;
    }

    /**
     * Add tourImages
     *
     * @param \Ghyneck\MapBundle\Entity\TourImage $tourImage
     * @return Tour
     */
    public function addImage(TourImage $tourImage)
    {
        $this->tourImages[] = $tourImage;
        $tourImage->setTour($this);

        return $this;
    }

    /**
     * Remove tourImages
     *
     * @param \Ghyneck\MapBundle\Entity\TourImage $tourImage
     */
    public function removeTourImage(TourImage $tourImage)
    {
        $this->tourImages->removeElement($tourImage);
        $tourImage->setTour(null);
    }

    /**
     * Get tourImages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTourImages()
    {
        return $this->tourImages;
    }


    /**
     * @var \Ghyneck\MapBundle\Entity\Category
     */
    private $category;


    /**
     * Add tourImages
     *
     * @param \Ghyneck\MapBundle\Entity\TourImage $tourImages
     * @return Tour
     */
    public function addTourImage(\Ghyneck\MapBundle\Entity\TourImage $tourImages)
    {
        $this->tourImages[] = $tourImages;

        return $this;
    }

    /**
     * Set category
     *
     * @param \Ghyneck\MapBundle\Entity\Category $category
     * @return Tour
     */
    public function setCategory(\Ghyneck\MapBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Ghyneck\MapBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}

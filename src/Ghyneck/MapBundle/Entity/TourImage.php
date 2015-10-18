<?php

namespace Ghyneck\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TourImage
 */
class TourImage
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    protected $tourId;

    /**
     * This value gets persisted
     *
     * @var string
     */
    private $fileName;

    /**
     * This value gets not persisted
     *
     * @var File $image
     */
    protected $image;

    /*
     * @var string
     */
    protected $altText = "";

    /**
     * @var \Ghyneck\MapBundle\Entity\Tour
     */
    protected $tour;


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
     * Set tour
     *
     * @param integer $tourId
     * @return TourImage
     */
    public function setTourId($tourId)
    {
        $this->tourId = $tourId;

        return $this;
    }

    /**
     * Get tourId
     *
     * @return integer
     */
    public function getTourId()
    {
        return $this->tourId;
    }

    /*
     * @param string $altText
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;
    }

    /*
     * @return string
     */
    public function getAltText()
    {
        return $this->altText;
    }


    /**
     * Set fileName
     *
     * @param string $fileName
     * @return TourImage
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set tour
     *
     * @param \Ghyneck\MapBundle\Entity\Tour $tour
     * @return TourImage
     */
    public function setTour(Tour $tour = null)
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * Get tour
     *
     * @return \Ghyneck\MapBundle\Entity\Tour
     */
    public function getTour()
    {
        return $this->tour;
    }

    public function setImage(File $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }
}

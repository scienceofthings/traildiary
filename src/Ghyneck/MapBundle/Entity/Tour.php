<?php

namespace Ghyneck\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @var Gpxfile
     */
    private $gpxfile;

    /**
     * @var float
     */
    private $markerlat;

    /**
     * @var float
     */
    private $markerlon;


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
     * Set gpxfile
     *
     * @param Gpxfile $gpxfile     
     */     
    public function setGpxFile($gpxfile)
    {
        $this->gpxfile = $gpxfile;       
    }

    /**
     * Get gpxfile
     *
     * @return Gpxfile
     */
    public function getGpxFile()
    {
        return $this->gpxfile;
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


}

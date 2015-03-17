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
     * @var string
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
     * @param UploadedFile $gpxfile     
     */
    public function setGpxFile($gpxfile)
    {
        $this->gpxfile = $gpxfile;       
    }

    /**
     * Get gpxfile
     *
     * @return UploadedFile
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
    
    public function upload() {
        // the file property can be empty if the field is not required
        if (null === $this->getGpxFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        $this->getGpxFile()->move(
                $this->getUploadRootDir(), $this->getGpxFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getGpxFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
    
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

}

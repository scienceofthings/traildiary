<?php

namespace Ghyneck\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gpxfile
 */
class Gpxfile
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $filename;

    /*
     * @var string
     */
    private $clientOriginalFileName;
            
    /**
     * @var UploadedFile
     */
    private $file;
    
    /**
     * @var string
     */
    private $tour;


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
     * Set name
     *
     * @param string $fileName
     * @return Gpxfile
     */
    public function setFileName($fileName)
    {
        $this->filename = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->filename;
    }
    
        /**
     * Set name
     *
     * @param string $clientOriginalFileName
     * @return Gpxfile
     */
    public function setClientOriginalFileName($clientOriginalFileName)
    {
        $this->clientOriginalFileName = $clientOriginalFileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getClientOriginalFileName()
    {
        return $this->clientOriginalFileName;
    }
        

    /**
     * Get file
     *
     * @param UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
    
    /**
     * Get file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    
    /**
     * Set tour
     *
     * @return string 
     */
    public function setTour($tour)
    {
        $this->file = $tour;
    }
    
    /**
     * Get tour
     *
     * @return string 
     */
    public function getTour()
    {
        return $this->tour;
    }
    
    
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {        
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->setFileName($filename.'.gpx');
        }
        $this->setClientOriginalFileName($this->getFile()->getClientOriginalName());
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error        
        $this->getFile()->move($this->getUploadRootDir(), $this->getFileName());        

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }        
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {        
        $fileWithAbsolutePath = $this->getFileWithAbsolutePath();        
        if ($fileWithAbsolutePath) {
            unlink($fileWithAbsolutePath);
        }
    }      
    
    public function getFileWithAbsolutePath()
    {              
        return null === $this->getFileName()
            ? null
            : $this->getUploadRootDir().'/'.$this->getFileName();
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

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrailRepository")
 */
class Trail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $directory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gpxFileName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gpxFile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="trail")
     */
    private $images;

    /**
     * @ORM\Column(type="float")
     */
    private $markerLatitude;

    /**
     * @ORM\Column(type="float")
     */
    private $markerLongitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="trails")
     */
    private $region;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDirectory(): ?string
    {
        return $this->directory;
    }

    public function setDirectory(string $directory): self
    {
        $this->directory = $directory;

        return $this;
    }

    public function getGpxFileName(): ?string
    {
        return $this->gpxFileName;
    }

    public function setGpxFileName(string $gpxFileName): self
    {
        $this->gpxFileName = $gpxFileName;

        return $this;
    }

    public function getGpxFile(): ?string
    {
        return $this->gpxFile;
    }

    public function setGpxFile(string $gpxFile): self
    {
        $this->gpxFile = $gpxFile;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setTrail($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getTrail() === $this) {
                $image->setTrail(null);
            }
        }

        return $this;
    }

    public function getMarkerLatitude(): ?float
    {
        return $this->markerLatitude;
    }

    public function setMarkerLatitude(float $markerLatitude): self
    {
        $this->markerLatitude = $markerLatitude;

        return $this;
    }

    public function getMarkerLongitude(): ?float
    {
        return $this->markerLongitude;
    }

    public function setMarkerLongitude(float $markerLongitude): self
    {
        $this->markerLongitude = $markerLongitude;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }
}

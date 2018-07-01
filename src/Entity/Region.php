<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
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
     * @ORM\OneToMany(targetEntity="App\Entity\Trail", mappedBy="region")
     */
    private $trails;

    public function __construct()
    {
        $this->trails = new ArrayCollection();
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

    /**
     * @return Collection|Trail[]
     */
    public function getTrails(): Collection
    {
        return $this->trails;
    }

    public function addTrail(Trail $trail): self
    {
        if (!$this->trails->contains($trail)) {
            $this->trails[] = $trail;
            $trail->setRegion($this);
        }

        return $this;
    }

    public function removeTrail(Trail $trail): self
    {
        if ($this->trails->contains($trail)) {
            $this->trails->removeElement($trail);
            // set the owning side to null (unless already changed)
            if ($trail->getRegion() === $this) {
                $trail->setRegion(null);
            }
        }

        return $this;
    }
}

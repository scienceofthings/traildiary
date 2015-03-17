<?php

namespace Ghyneck\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    /**
     * 
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    
    /**
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $products
     * @return \Ghyneck\MapBundle\Entity\Category
     */
    public function setProducts($products)
    {
        $this->products = $products;
        
        return $this;
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
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}

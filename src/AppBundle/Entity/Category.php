<?php

namespace AppBundle\Entity;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $catId;

    /**
     * @var string
     */
    private $catName;

    /**
     * @var string
     */
    private $catIcon;

    /**
     * @var boolean
     */
    private $catActive = '1';


    /**
     * Get catId
     *
     * @return integer
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * Set catName
     *
     * @param string $catName
     *
     * @return Category
     */
    public function setCatName($catName)
    {
        $this->catName = $catName;

        return $this;
    }

    /**
     * Get catName
     *
     * @return string
     */
    public function getCatName()
    {
        return $this->catName;
    }

    /**
     * Set catIcon
     *
     * @param string $catIcon
     *
     * @return Category
     */
    public function setCatIcon($catIcon)
    {
        $this->catIcon = $catIcon;

        return $this;
    }

    /**
     * Get catIcon
     *
     * @return string
     */
    public function getCatIcon()
    {
        return $this->catIcon;
    }

    /**
     * Set catActive
     *
     * @param boolean $catActive
     *
     * @return Category
     */
    public function setCatActive($catActive)
    {
        $this->catActive = $catActive;

        return $this;
    }

    /**
     * Get catActive
     *
     * @return boolean
     */
    public function getCatActive()
    {
        return $this->catActive;
    }
}

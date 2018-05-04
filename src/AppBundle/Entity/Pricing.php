<?php

namespace AppBundle\Entity;

/**
 * Pricing
 */
class Pricing
{
    /**
     * @var integer
     */
    private $prId;

    /**
     * @var string
     */
    private $prPlan;

    /**
     * @var string
     */
    private $prMonths;

    /**
     * @var float
     */
    private $prPrice;

    /**
     * @var string
     */
    private $prDescription;

    /**
     * @var boolean
     */
    private $prActive = true;


    /**
     * Get prId
     *
     * @return integer
     */
    public function getPrId()
    {
        return $this->prId;
    }

    /**
     * Set prPlan
     *
     * @param string $prPlan
     *
     * @return Pricing
     */
    public function setPrPlan($prPlan)
    {
        $this->prPlan = $prPlan;

        return $this;
    }

    /**
     * Get prPlan
     *
     * @return string
     */
    public function getPrPlan()
    {
        return $this->prPlan;
    }

    /**
     * Set prMonths
     *
     * @param string $prMonths
     *
     * @return Pricing
     */
    public function setPrMonths($prMonths)
    {
        $this->prMonths = $prMonths;

        return $this;
    }

    /**
     * Get prMonths
     *
     * @return string
     */
    public function getPrMonths()
    {
        return $this->prMonths;
    }

    /**
     * Set prPrice
     *
     * @param float $prPrice
     *
     * @return Pricing
     */
    public function setPrPrice($prPrice)
    {
        $this->prPrice = $prPrice;

        return $this;
    }

    /**
     * Get prPrice
     *
     * @return float
     */
    public function getPrPrice()
    {
        return $this->prPrice;
    }

    /**
     * Set prDescription
     *
     * @param string $prDescription
     *
     * @return Pricing
     */
    public function setPrDescription($prDescription)
    {
        $this->prDescription = $prDescription;

        return $this;
    }

    /**
     * Get prDescription
     *
     * @return string
     */
    public function getPrDescription()
    {
        return $this->prDescription;
    }

    /**
     * Set prActive
     *
     * @param boolean $prActive
     *
     * @return Pricing
     */
    public function setPrActive($prActive)
    {
        $this->prActive = $prActive;

        return $this;
    }

    /**
     * Get prActive
     *
     * @return boolean
     */
    public function getPrActive()
    {
        return $this->prActive;
    }
}

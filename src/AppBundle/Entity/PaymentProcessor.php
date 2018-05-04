<?php

namespace AppBundle\Entity;

/**
 * PaymentProcessor
 */
class PaymentProcessor
{
    /**
     * @var integer
     */
    private $ppId;

    /**
     * @var string
     */
    private $ppName;

    /**
     * @var string
     */
    private $ppKey;

    /**
     * @var string
     */
    private $ppUrlLogo;

    /**
     * @var boolean
     */
    private $ppActive = '1';


    /**
     * Get ppId
     *
     * @return integer
     */
    public function getPpId()
    {
        return $this->ppId;
    }

    /**
     * Set ppName
     *
     * @param string $ppName
     *
     * @return PaymentProcessor
     */
    public function setPpName($ppName)
    {
        $this->ppName = $ppName;

        return $this;
    }

    /**
     * Get ppName
     *
     * @return string
     */
    public function getPpName()
    {
        return $this->ppName;
    }

    /**
     * Set ppKey
     *
     * @param string $ppKey
     *
     * @return PaymentProcessor
     */
    public function setPpKey($ppKey)
    {
        $this->ppKey = $ppKey;

        return $this;
    }

    /**
     * Get ppKey
     *
     * @return string
     */
    public function getPpKey()
    {
        return $this->ppKey;
    }

    /**
     * Set ppUrlLogo
     *
     * @param string $ppUrlLogo
     *
     * @return PaymentProcessor
     */
    public function setPpUrlLogo($ppUrlLogo)
    {
        $this->ppUrlLogo = $ppUrlLogo;

        return $this;
    }

    /**
     * Get ppUrlLogo
     *
     * @return string
     */
    public function getPpUrlLogo()
    {
        return $this->ppUrlLogo;
    }

    /**
     * Set ppActive
     *
     * @param boolean $ppActive
     *
     * @return PaymentProcessor
     */
    public function setPpActive($ppActive)
    {
        $this->ppActive = $ppActive;

        return $this;
    }

    /**
     * Get ppActive
     *
     * @return boolean
     */
    public function getPpActive()
    {
        return $this->ppActive;
    }
}

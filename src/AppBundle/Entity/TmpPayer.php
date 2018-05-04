<?php

namespace AppBundle\Entity;

/**
 * TmpPayer
 */
class TmpPayer
{
    /**
     * @var integer
     */
    private $tmpId;

    /**
     * @var string
     */
    private $tmpGatewayIdToken;

    /**
     * @var \DateTime
     */
    private $tmpCreated;

    /**
     * @var integer
     */
    private $tmpCompleted;


    /**
     * Get tmpId
     *
     * @return integer
     */
    public function getTmpId()
    {
        return $this->tmpId;
    }

    /**
     * Set tmpGatewayIdToken
     *
     * @param string $tmpGatewayIdToken
     *
     * @return TmpPayer
     */
    public function setTmpGatewayIdToken($tmpGatewayIdToken)
    {
        $this->tmpGatewayIdToken = $tmpGatewayIdToken;

        return $this;
    }

    /**
     * Get tmpGatewayIdToken
     *
     * @return string
     */
    public function getTmpGatewayIdToken()
    {
        return $this->tmpGatewayIdToken;
    }

    /**
     * Set tmpCreated
     *
     * @param \DateTime $tmpCreated
     *
     * @return TmpPayer
     */
    public function setTmpCreated($tmpCreated)
    {
        $this->tmpCreated = $tmpCreated;

        return $this;
    }

    /**
     * Get tmpCreated
     *
     * @return \DateTime
     */
    public function getTmpCreated()
    {
        return $this->tmpCreated;
    }

    /**
     * Set tmpCompleted
     *
     * @param integer $tmpCompleted
     *
     * @return TmpPayer
     */
    public function setTmpCompleted($tmpCompleted)
    {
        $this->tmpCompleted = $tmpCompleted;

        return $this;
    }

    /**
     * Get tmpCompleted
     *
     * @return integer
     */
    public function getTmpCompleted()
    {
        return $this->tmpCompleted;
    }
}

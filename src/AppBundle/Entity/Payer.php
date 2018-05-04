<?php

namespace AppBundle\Entity;

/**
 * Payer
 */
class Payer
{
    /**
     * @var integer
     */
    private $payId;

    /**
     * @var float
     */
    private $payMoneyPaid;

    /**
     * @var string
     */
    private $payGatewayIdPayer;

    /**
     * @var string
     */
    private $payGatewayIdTransaction;

    /**
     * @var string
     */
    private $payGatewayIdToken;

    /**
     * @var string
     */
    private $payHttpGatewayParsedResponse;

    /**
     * @var boolean
     */
    private $payIsPaid;

    /**
     * @var boolean
     */
    private $payActive = '1';

    /**
     * @var \DateTime
     */
    private $payDeadline;

    /**
     * @var \DateTime
     */
    private $payCreated = 'CURRENT_TIMESTAMP';

    /**
     * @var \AppBundle\Entity\PaymentProcessor
     */
    private $pp;

    /**
     * @var \AppBundle\Entity\Pricing
     */
    private $pr;

    /**
     * @var \AppBundle\Entity\User
     */
    private $usr;


    /**
     * Get payId
     *
     * @return integer
     */
    public function getPayId()
    {
        return $this->payId;
    }

    /**
     * Set payMoneyPaid
     *
     * @param float $payMoneyPaid
     *
     * @return Payer
     */
    public function setPayMoneyPaid($payMoneyPaid)
    {
        $this->payMoneyPaid = $payMoneyPaid;

        return $this;
    }

    /**
     * Get payMoneyPaid
     *
     * @return float
     */
    public function getPayMoneyPaid()
    {
        return $this->payMoneyPaid;
    }

    /**
     * Set payGatewayIdPayer
     *
     * @param string $payGatewayIdPayer
     *
     * @return Payer
     */
    public function setPayGatewayIdPayer($payGatewayIdPayer)
    {
        $this->payGatewayIdPayer = $payGatewayIdPayer;

        return $this;
    }

    /**
     * Get payGatewayIdPayer
     *
     * @return string
     */
    public function getPayGatewayIdPayer()
    {
        return $this->payGatewayIdPayer;
    }

    /**
     * Set payGatewayIdTransaction
     *
     * @param string $payGatewayIdTransaction
     *
     * @return Payer
     */
    public function setPayGatewayIdTransaction($payGatewayIdTransaction)
    {
        $this->payGatewayIdTransaction = $payGatewayIdTransaction;

        return $this;
    }

    /**
     * Get payGatewayIdTransaction
     *
     * @return string
     */
    public function getPayGatewayIdTransaction()
    {
        return $this->payGatewayIdTransaction;
    }

    /**
     * Set payGatewayIdToken
     *
     * @param string $payGatewayIdToken
     *
     * @return Payer
     */
    public function setPayGatewayIdToken($payGatewayIdToken)
    {
        $this->payGatewayIdToken = $payGatewayIdToken;

        return $this;
    }

    /**
     * Get payGatewayIdToken
     *
     * @return string
     */
    public function getPayGatewayIdToken()
    {
        return $this->payGatewayIdToken;
    }

    /**
     * Set payHttpGatewayParsedResponse
     *
     * @param string $payHttpGatewayParsedResponse
     *
     * @return Payer
     */
    public function setPayHttpGatewayParsedResponse($payHttpGatewayParsedResponse)
    {
        $this->payHttpGatewayParsedResponse = $payHttpGatewayParsedResponse;

        return $this;
    }

    /**
     * Get payHttpGatewayParsedResponse
     *
     * @return string
     */
    public function getPayHttpGatewayParsedResponse()
    {
        return $this->payHttpGatewayParsedResponse;
    }

    /**
     * Set payIsPaid
     *
     * @param boolean $payIsPaid
     *
     * @return Payer
     */
    public function setPayIsPaid($payIsPaid)
    {
        $this->payIsPaid = $payIsPaid;

        return $this;
    }

    /**
     * Get payIsPaid
     *
     * @return boolean
     */
    public function getPayIsPaid()
    {
        return $this->payIsPaid;
    }

    /**
     * Set payActive
     *
     * @param boolean $payActive
     *
     * @return Payer
     */
    public function setPayActive($payActive)
    {
        $this->payActive = $payActive;

        return $this;
    }

    /**
     * Get payActive
     *
     * @return boolean
     */
    public function getPayActive()
    {
        return $this->payActive;
    }

    /**
     * Set payDeadline
     *
     * @param \DateTime $payDeadline
     *
     * @return Payer
     */
    public function setPayDeadline($payDeadline)
    {
        $this->payDeadline = $payDeadline;

        return $this;
    }

    /**
     * Get payDeadline
     *
     * @return \DateTime
     */
    public function getPayDeadline()
    {
        return $this->payDeadline;
    }

    /**
     * Set payCreated
     *
     * @param \DateTime $payCreated
     *
     * @return Payer
     */
    public function setPayCreated($payCreated)
    {
        $this->payCreated = $payCreated;

        return $this;
    }

    /**
     * Get payCreated
     *
     * @return \DateTime
     */
    public function getPayCreated()
    {
        return $this->payCreated;
    }

    /**
     * Set pp
     *
     * @param \AppBundle\Entity\PaymentProcessor $pp
     *
     * @return Payer
     */
    public function setPp(\AppBundle\Entity\PaymentProcessor $pp = null)
    {
        $this->pp = $pp;

        return $this;
    }

    /**
     * Get pp
     *
     * @return \AppBundle\Entity\PaymentProcessor
     */
    public function getPp()
    {
        return $this->pp;
    }

    /**
     * Set pr
     *
     * @param \AppBundle\Entity\Pricing $pr
     *
     * @return Payer
     */
    public function setPr(\AppBundle\Entity\Pricing $pr = null)
    {
        $this->pr = $pr;

        return $this;
    }

    /**
     * Get pr
     *
     * @return \AppBundle\Entity\Pricing
     */
    public function getPr()
    {
        return $this->pr;
    }

    /**
     * Set usr
     *
     * @param \AppBundle\Entity\User $usr
     *
     * @return Payer
     */
    public function setUsr(\AppBundle\Entity\User $usr = null)
    {
        $this->usr = $usr;

        return $this;
    }

    /**
     * Get usr
     *
     * @return \AppBundle\Entity\User
     */
    public function getUsr()
    {
        return $this->usr;
    }
}


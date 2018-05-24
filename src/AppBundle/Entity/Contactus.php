<?php

namespace AppBundle\Entity;

/**
 * Contactus
 */
class Contactus
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $contId;

    /**
     * @var string
     */
    private $conName;

    /**
     * @var string
     */
    private $conEmail;

    /**
     * @var string
     */
    private $conPhone;

    /**
     * @var string
     */
    private $conComment;

    /**
     * @var \DateTime
     */
    private $conCreate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contId
     *
     * @param integer $contId
     *
     * @return Contactus
     */
    public function setContId($contId)
    {
        $this->contId = $contId;

        return $this;
    }

    /**
     * Get contId
     *
     * @return int
     */
    public function getContId()
    {
        return $this->contId;
    }

    /**
     * Set conName
     *
     * @param string $conName
     *
     * @return Contactus
     */
    public function setConName($conName)
    {
        $this->conName = $conName;

        return $this;
    }

    /**
     * Get conName
     *
     * @return string
     */
    public function getConName()
    {
        return $this->conName;
    }

    /**
     * Set conEmail
     *
     * @param string $conEmail
     *
     * @return Contactus
     */
    public function setConEmail($conEmail)
    {
        $this->conEmail = $conEmail;

        return $this;
    }

    /**
     * Get conEmail
     *
     * @return string
     */
    public function getConEmail()
    {
        return $this->conEmail;
    }

    /**
     * Set conPhone
     *
     * @param string $conPhone
     *
     * @return Contactus
     */
    public function setConPhone($conPhone)
    {
        $this->conPhone = $conPhone;

        return $this;
    }

    /**
     * Get conPhone
     *
     * @return string
     */
    public function getConPhone()
    {
        return $this->conPhone;
    }

    /**
     * Set conComment
     *
     * @param string $conComment
     *
     * @return Contactus
     */
    public function setConComment($conComment)
    {
        $this->conComment = $conComment;

        return $this;
    }

    /**
     * Get conComment
     *
     * @return string
     */
    public function getConComment()
    {
        return $this->conComment;
    }

    /**
     * Set conCreate
     *
     * @param \DateTime $conCreate
     *
     * @return Contactus
     */
    public function setConCreate($conCreate)
    {
        $this->conCreate = $conCreate;

        return $this;
    }

    /**
     * Get conCreate
     *
     * @return \DateTime
     */
    public function getConCreate()
    {
        return $this->conCreate;
    }
}

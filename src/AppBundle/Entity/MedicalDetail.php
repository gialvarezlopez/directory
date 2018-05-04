<?php

namespace AppBundle\Entity;

/**
 * MedicalDetail
 */
class MedicalDetail
{
    /**
     * @var integer
     */
    private $mdId;

    /**
     * @var string
     */
    private $mdProfileImage;

    /**
     * @var string
     */
    private $mdProfileDescription;

    /**
     * @var string
     */
    private $mdAcademicTraining;

    /**
     * @var string
     */
    private $mdProfessionalExperience;

    /**
     * @var string
     */
    private $mdCoursesSeminars;

    /**
     * @var string
     */
    private $mdAditionalInformation;

    /**
     * @var string
     */
    private $mdFirstName;

    /**
     * @var string
     */
    private $mdMiddleName;

    /**
     * @var string
     */
    private $mdFirstSurname;

    /**
     * @var string
     */
    private $mdSecondSurname;

    /**
     * @var boolean
     */
    private $mdActive = true;

    /**
     * @var \DateTime
     */
    private $mdCreated = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     */
    private $mdUpdated;

    /**
     * @var \AppBundle\Entity\User
     */
    private $usr;


    public function __construct()
    {
        $this->mdCreated = new \DateTime();
    }

    /**
     * Get mdId
     *
     * @return integer
     */
    public function getMdId()
    {
        return $this->mdId;
    }

    /**
     * Set mdProfileImage
     *
     * @param string $mdProfileImage
     *
     * @return MedicalDetail
     */
    public function setMdProfileImage($mdProfileImage)
    {
        $this->mdProfileImage = $mdProfileImage;

        return $this;
    }

    /**
     * Get mdProfileImage
     *
     * @return string
     */
    public function getMdProfileImage()
    {
        return $this->mdProfileImage;
    }

    /**
     * Set mdProfileDescription
     *
     * @param string $mdProfileDescription
     *
     * @return MedicalDetail
     */
    public function setMdProfileDescription($mdProfileDescription)
    {
        $this->mdProfileDescription = $mdProfileDescription;

        return $this;
    }

    /**
     * Get mdProfileDescription
     *
     * @return string
     */
    public function getMdProfileDescription()
    {
        return $this->mdProfileDescription;
    }

    /**
     * Set mdAcademicTraining
     *
     * @param string $mdAcademicTraining
     *
     * @return MedicalDetail
     */
    public function setMdAcademicTraining($mdAcademicTraining)
    {
        $this->mdAcademicTraining = $mdAcademicTraining;

        return $this;
    }

    /**
     * Get mdAcademicTraining
     *
     * @return string
     */
    public function getMdAcademicTraining()
    {
        return $this->mdAcademicTraining;
    }

    /**
     * Set mdProfessionalExperience
     *
     * @param string $mdProfessionalExperience
     *
     * @return MedicalDetail
     */
    public function setMdProfessionalExperience($mdProfessionalExperience)
    {
        $this->mdProfessionalExperience = $mdProfessionalExperience;

        return $this;
    }

    /**
     * Get mdProfessionalExperience
     *
     * @return string
     */
    public function getMdProfessionalExperience()
    {
        return $this->mdProfessionalExperience;
    }

    /**
     * Set mdCoursesSeminars
     *
     * @param string $mdCoursesSeminars
     *
     * @return MedicalDetail
     */
    public function setMdCoursesSeminars($mdCoursesSeminars)
    {
        $this->mdCoursesSeminars = $mdCoursesSeminars;

        return $this;
    }

    /**
     * Get mdCoursesSeminars
     *
     * @return string
     */
    public function getMdCoursesSeminars()
    {
        return $this->mdCoursesSeminars;
    }

    /**
     * Set mdAditionalInformation
     *
     * @param string $mdAditionalInformation
     *
     * @return MedicalDetail
     */
    public function setMdAditionalInformation($mdAditionalInformation)
    {
        $this->mdAditionalInformation = $mdAditionalInformation;

        return $this;
    }

    /**
     * Get mdAditionalInformation
     *
     * @return string
     */
    public function getMdAditionalInformation()
    {
        return $this->mdAditionalInformation;
    }

    /**
     * Set mdFirstName
     *
     * @param string $mdFirstName
     *
     * @return MedicalDetail
     */
    public function setMdFirstName($mdFirstName)
    {
        $this->mdFirstName = $mdFirstName;

        return $this;
    }

    /**
     * Get mdFirstName
     *
     * @return string
     */
    public function getMdFirstName()
    {
        return $this->mdFirstName;
    }

    /**
     * Set mdMiddleName
     *
     * @param string $mdMiddleName
     *
     * @return MedicalDetail
     */
    public function setMdMiddleName($mdMiddleName)
    {
        $this->mdMiddleName = $mdMiddleName;

        return $this;
    }

    /**
     * Get mdMiddleName
     *
     * @return string
     */
    public function getMdMiddleName()
    {
        return $this->mdMiddleName;
    }

    /**
     * Set mdFirstSurname
     *
     * @param string $mdFirstSurname
     *
     * @return MedicalDetail
     */
    public function setMdFirstSurname($mdFirstSurname)
    {
        $this->mdFirstSurname = $mdFirstSurname;

        return $this;
    }

    /**
     * Get mdFirstSurname
     *
     * @return string
     */
    public function getMdFirstSurname()
    {
        return $this->mdFirstSurname;
    }

    /**
     * Set mdSecondSurname
     *
     * @param string $mdSecondSurname
     *
     * @return MedicalDetail
     */
    public function setMdSecondSurname($mdSecondSurname)
    {
        $this->mdSecondSurname = $mdSecondSurname;

        return $this;
    }

    /**
     * Get mdSecondSurname
     *
     * @return string
     */
    public function getMdSecondSurname()
    {
        return $this->mdSecondSurname;
    }

    /**
     * Set mdActive
     *
     * @param boolean $mdActive
     *
     * @return MedicalDetail
     */
    public function setMdActive($mdActive)
    {
        $this->mdActive = $mdActive;

        return $this;
    }

    /**
     * Get mdActive
     *
     * @return boolean
     */
    public function getMdActive()
    {
        return $this->mdActive;
    }

    /**
     * Set mdCreated
     *
     * @param \DateTime $mdCreated
     *
     * @return MedicalDetail
     */
    public function setMdCreated($mdCreated)
    {
        $this->mdCreated = $mdCreated;

        return $this;
    }

    /**
     * Get mdCreated
     *
     * @return \DateTime
     */
    public function getMdCreated()
    {
        return $this->mdCreated;
    }

    /**
     * Set mdUpdated
     *
     * @param \DateTime $mdUpdated
     *
     * @return MedicalDetail
     */
    public function setMdUpdated($mdUpdated)
    {
        $this->mdUpdated = $mdUpdated;

        return $this;
    }

    /**
     * Get mdUpdated
     *
     * @return \DateTime
     */
    public function getMdUpdated()
    {
        return $this->mdUpdated;
    }

    /**
     * Set usr
     *
     * @param \AppBundle\Entity\User $usr
     *
     * @return MedicalDetail
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

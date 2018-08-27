<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceProvider
 *
 * @ORM\Table(name="service_provider")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceProviderRepository")
 */
class ServiceProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="service_provider_id", type="bigint")
     */
    private $serviceProviderId;

    /**
     * @var string
     *
     * @ORM\Column(name="service_provider_name", type="string", length=50)
     */
    private $serviceProviderName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date_time", type="datetime")
     */
    private $createdDateTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_date_time", type="datetime")
     */
    private $updatedDateTime;

    public function __construct()
    {
        $this->createdDateTime = new \DateTime();
        $this->updatedDateTime = new \DateTime();
    }

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
     * Set serviceProviderId
     *
     * @param integer $serviceProviderId
     *
     * @return ServiceProvider
     */
    public function setServiceProviderId($serviceProviderId)
    {
        $this->serviceProviderId = $serviceProviderId;

        return $this;
    }

    /**
     * Get serviceProviderId
     *
     * @return int
     */
    public function getServiceProviderId()
    {
        return $this->serviceProviderId;
    }

    /**
     * Set serviceProviderName
     *
     * @param string $serviceProviderName
     *
     * @return ServiceProvider
     */
    public function setServiceProviderName($serviceProviderName)
    {
        $this->serviceProviderName = $serviceProviderName;

        return $this;
    }

    /**
     * Get serviceProviderName
     *
     * @return string
     */
    public function getServiceProviderName()
    {
        return $this->serviceProviderName;
    }

    /**
     * Set createdDateTime
     *
     * @param \DateTime $createdDateTime
     *
     * @return ServiceProvider
     */
    public function setCreatedDateTime($createdDateTime)
    {
        $this->createdDateTime = $createdDateTime;

        return $this;
    }

    /**
     * Get createdDateTime
     *
     * @return \DateTime
     */
    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
    }

    /**
     * Set updatedDateTime
     *
     * @param \DateTime $updatedDateTime
     *
     * @return ServiceProvider
     */
    public function setUpdatedDateTime($updatedDateTime)
    {
        $this->updatedDateTime = $updatedDateTime;

        return $this;
    }

    /**
     * Get updatedDateTime
     *
     * @return \DateTime
     */
    public function getUpdatedDateTime()
    {
        return $this->updatedDateTime;
    }
}


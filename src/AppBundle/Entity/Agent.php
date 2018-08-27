<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agent
 *
 * @ORM\Table(name="agent")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AgentRepository")
 */
class Agent
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
     * @ORM\Column(name="agent_id", type="bigint")
     */
    private $agentId;

    /**
     * @var string
     *
     * @ORM\Column(name="api_key", type="string", length=150)
     */
    private $apiKey;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

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

    /**
     * One Agent has One ServiceProvider.
     * @ORM\OneToOne(targetEntity="ServiceProvider")
     * @ORM\JoinColumn(name="sp_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $serviceProvider;

    /**
     * One Agent has One User.
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

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
     * Set agentId
     *
     * @param integer $agentId
     *
     * @return Agent
     */
    public function setAgentId($agentId)
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * Get agentId
     *
     * @return int
     */
    public function getAgentId()
    {
        return $this->agentId;
    }

    /**
     * Set apiKey
     *
     * @param string $apiKey
     *
     * @return Agent
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get apiKey
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set status
     *
     * @param bool $status
     *
     * @return Agent
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdDateTime
     *
     * @param \DateTime $createdDateTime
     *
     * @return Agent
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
     * @return Agent
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


    /**
     * Set serviceProvider
     *
     * @param TransactionLog $transactionLog
     *
     * @return ServiceProvider
     */
    public function setServiceProvider(ServiceProvider $serviceProvider = null)
    {
        $this->serviceProvider = $serviceProvider;

        return $this;
    }

    /**
     * Get serviceProvider
     *
     * @return ServiceProvider
     */
    public function getServiceProvider()
    {
        return $this->serviceProvider;
    }


    /**
     * Set user
     *
     * @param User $user
     *
     * @return Session
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}


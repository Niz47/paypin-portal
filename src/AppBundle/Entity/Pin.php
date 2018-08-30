<?php

namespace AppBundle\Entity;

/**
 * Pin
 */
class Pin
{

    /**
     * @var int
     *
     */
    private $serviceProviderId;

    /**
     * @var int
     *
     */
    private $agentId;

    /**
     * @var string
     *
     */
    private $secretKey;

    /**
     * @var int
     *
     */
    private $pinCode;

    /**
     * Set serviceProviderId
     *
     * @param integer $serviceProviderId
     *
     * @return Pin
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
     * @return Pin
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
     * Set secretKey
     *
     * @param string $secretKey
     *
     * @return Pin
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * Get secretKey
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Set pinCode
     *
     * @param integer $pinCode
     *
     * @return Pin
     */
    public function setPinCode($pinCode)
    {
        $this->pinCode = $pinCode;

        return $this;
    }

    /**
     * Get pinCode
     *
     * @return int
     */
    public function getPinCode()
    {
        return $this->pinCode;
    }
}


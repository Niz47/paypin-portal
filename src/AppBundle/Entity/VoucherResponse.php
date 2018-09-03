<?php

namespace AppBundle\Entity;

/**
 * VoucherResponse
 */
class VoucherResponse
{
    /**
     * @var string
     *
     */
    public $voucherReferenceID;

    /**
     * @var string
     *
     */
    public $serialNo;

    /**
     * @var string
     *
     */
    public $amount;

    /**
     * @var string
     *
     */
    public $voucherStatus;

    /**
     * @var string
     *
     */
    public $submitDate;

    /**
     * @var string
     *
     */
    public $redemeeDate;

    /**
     * @var string
     *
     */
    public $lastUpdateDate;

    /**
     * Set voucherReferenceID
     *
     * @param string $voucherReferenceID
     *
     * @return Pin
     */
    public function setVoucherReferenceID($voucherReferenceID)
    {
        $this->voucherReferenceID = $voucherReferenceID;

        return $this;
    }

    /**
     * Get voucherReferenceID
     *
     * @return string
     */
    public function getVoucherReferenceID()
    {
        return $this->voucherReferenceID;
    }

    /**
     * Set serialNo
     *
     * @param string $serialNo
     *
     * @return Pin
     */
    public function setSerialNo($serialNo)
    {
        $this->serialNo = $serialNo;

        return $this;
    }

    /**
     * Get serialNo
     *
     * @return string
     */
    public function getSerialNo()
    {
        return $this->serialNo;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Pin
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set voucherStatus
     *
     * @param string $voucherStatus
     *
     * @return Pin
     */
    public function setVoucherStatus($voucherStatus)
    {
        $this->voucherStatus = $voucherStatus;

        return $this;
    }

    /**
     * Get voucherStatus
     *
     * @return string
     */
    public function getVoucherStatus()
    {
        return $this->voucherStatus;
    }

    /**
     * Set submitDate
     *
     * @param string $submitDate
     *
     * @return Pin
     */
    public function setSubmitDate($submitDate)
    {
        $this->submitDate = $submitDate;

        return $this;
    }

    /**
     * Get submitDate
     *
     * @return string
     */
    public function getSubmitDate()
    {
        return $this->submitDate;
    }

    /**
     * Set redemeeDate
     *
     * @param string $redemeeDate
     *
     * @return Pin
     */
    public function setRedemeeDate($redemeeDate)
    {
        $this->redemeeDate = $redemeeDate;

        return $this;
    }

    /**
     * Get redemeeDate
     *
     * @return string
     */
    public function getRedemeeDate()
    {
        return $this->redemeeDate;
    }

    /**
     * Set lastUpdateDate
     *
     * @param string $lastUpdateDate
     *
     * @return Pin
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;

        return $this;
    }

    /**
     * Get lastUpdateDate
     *
     * @return string
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }
}
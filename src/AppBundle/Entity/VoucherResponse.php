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
     * @var Datetime
     *
     */
    public $expireDate;

    /**
     * @var string
     *
     */
    public $nextStatus;

    /**
     * Set voucherReferenceID
     *
     * @param string $voucherReferenceID
     *
     * @return VoucherResponse
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
     * @return VoucherResponse
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
     * @return VoucherResponse
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
     * @return VoucherResponse
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
     * @return VoucherResponse
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
     * @return VoucherResponse
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
     * Set expireDate
     *
     * @param Datetime $expireDate
     *
     * @return VoucherResponse
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    /**
     * Get expireDate
     *
     * @return Datetime
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * Set nextStatus
     *
     * @param string $nextStatus
     *
     * @return VoucherResponse
     */
    public function setNextStatus($nextStatus)
    {
        $this->nextStatus = $nextStatus;

        return $this;
    }

    /**
     * Get nextStatus
     *
     * @return string
     */
    public function getNextStatus()
    {
        return $this->nextStatus;
    }
}
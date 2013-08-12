<?php

namespace AqBanking;

class Bank
{
    /**
     * @var BankCode
     */
    private $bankCode;

    /**
     * @var string
     */
    private $hbciUrl;

    /**
     * @var HbciVersion|null
     */
    private $hbciVersion;

    /**
     * @param BankCode $bankCode
     * @param string $hbciUrl
     * @param HbciVersion|null $hbciVersion
     */
    public function __construct(BankCode $bankCode, $hbciUrl, HbciVersion $hbciVersion = null)
    {
        $this->bankCode = $bankCode;
        $this->hbciUrl = $hbciUrl;
        $this->hbciVersion = $hbciVersion;
    }

    /**
     * @return BankCode
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }

    /**
     * @return string
     */
    public function getHbciUrl()
    {
        return $this->hbciUrl;
    }

    /**
     * @return HbciVersion|null
     */
    public function getHbciVersion()
    {
        return $this->hbciVersion;
    }
}

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
     * @param BankCode $bankCode
     * @param string $hbciUrl
     */
    public function __construct(BankCode $bankCode, $hbciUrl)
    {
        $this->bankCode = $bankCode;
        $this->hbciUrl = $hbciUrl;
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
}

<?php

namespace AqBanking;

class Account
{
    /**
     * @var string
     */
    private $bankCode;

    /**
     * @var string
     */
    private $accountNumber;

    /**
     * @param string $bankCode
     * @param $accountNumber
     * @return \AqBanking\Account
     */
    public function __construct($bankCode, $accountNumber)
    {
        $this->bankCode = $bankCode;
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return string
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
}

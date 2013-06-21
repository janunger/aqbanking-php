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
     * @var string
     */
    private $accountHolderName;

    /**
     * @param string $bankCode
     * @param string $accountNumber
     * @param string $accountHolderName
     * @return \AqBanking\Account
     */
    public function __construct($bankCode, $accountNumber, $accountHolderName = '')
    {
        $this->bankCode = $bankCode;
        $this->accountNumber = $accountNumber;
        $this->accountHolderName = $accountHolderName;
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

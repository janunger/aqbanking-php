<?php

namespace AqBanking;

class Account implements AccountInterface
{
    /**
     * @var BankCode
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
     * @param BankCode $bankCode
     * @param string $accountNumber
     * @param string $accountHolderName
     * @return \AqBanking\Account
     */
    public function __construct(BankCode $bankCode, $accountNumber, $accountHolderName = '')
    {
        $this->bankCode = $bankCode;
        $this->accountNumber = $accountNumber;
        $this->accountHolderName = $accountHolderName;
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
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @return string
     */
    public function getAccountHolderName()
    {
        return $this->accountHolderName;
    }
}

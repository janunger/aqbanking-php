<?php

namespace AqBanking;

class Account
{
    /**
     * @var Bank
     */
    private $bank;

    /**
     * @var string
     */
    private $accountNumber;

    /**
     * @param Bank $bank
     * @param string $accountNumber
     */
    public function __construct(Bank $bank, $accountNumber)
    {
        $this->bank = $bank;
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return string
     */
    public function getBankCode()
    {
        return $this->bank->getBankCode();
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
}

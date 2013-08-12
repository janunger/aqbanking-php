<?php

namespace AqBanking;

class BankCode
{
    /**
     * @var string
     */
    private $bankCode;

    /**
     * @param string $bankCode
     */
    public function __construct($bankCode)
    {
        $this->bankCode = $bankCode;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->bankCode;
    }

    /**
     * @param BankCode $bankCode
     * @return bool
     */
    public function equals(BankCode $bankCode)
    {
        return $bankCode->bankCode === $this->bankCode;
    }
}

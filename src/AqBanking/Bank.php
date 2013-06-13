<?php

namespace AqBanking;

class Bank
{
    /**
     * @var string
     */
    private $bankCode;

    private $serverUrl;

    private $hbciVersion;

    private $userFlags;

    /**
     * @param string $bankCode
     */
    function __construct($bankCode)
    {
        $this->bankCode = $bankCode;
    }

    /**
     * @return string
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }
}

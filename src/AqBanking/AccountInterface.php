<?php

namespace AqBanking;

interface AccountInterface
{
    /**
     * @return BankCode
     */
    public function getBankCode();

    /**
     * @return string
     */
    public function getAccountHolderName();

    /**
     * @return string
     */
    public function getAccountNumber();
}

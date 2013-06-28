<?php

namespace AqBanking;

use Money\Money;

class Transaction
{
    /**
     * @var Account
     */
    private $localAccount;

    /**
     * @var Account
     */
    private $remoteAccount;

    /**
     * @var string
     */
    private $purpose;

    /**
     * @var \DateTime
     */
    private $valutaDate;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var Money
     */
    private $value;

    public function __construct(
        Account $localAccount,
        Account $remoteAccount,
        $purpose,
        \DateTime $valutaDate,
        \DateTime $date,
        Money $value
    )
    {
        $this->date = $date;
        $this->localAccount = $localAccount;
        $this->purpose = $purpose;
        $this->remoteAccount = $remoteAccount;
        $this->value = $value;
        $this->valutaDate = $valutaDate;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return \AqBanking\Account
     */
    public function getLocalAccount()
    {
        return $this->localAccount;
    }

    /**
     * @return string
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * @return \AqBanking\Account
     */
    public function getRemoteAccount()
    {
        return $this->remoteAccount;
    }

    /**
     * @return \Money\Money
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \DateTime
     */
    public function getValutaDate()
    {
        return $this->valutaDate;
    }
}

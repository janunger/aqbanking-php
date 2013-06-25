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
}

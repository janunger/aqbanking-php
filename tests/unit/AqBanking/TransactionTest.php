<?php

namespace AqBanking;

use Money\Currency;
use Money\Money;

class TransactionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_instantiate_with_valid_values()
    {
        $localAccount = new Account(new BankCode('50951469'), '12345678');
        $remoteAccount = new Account(new BankCode('50951469'), '87654321');
        $purpose = 'Some purpose';
        $valutaDate = new \DateTime('today');
        $date = new \DateTime('yesterday');
        $value = new Money(100, new Currency('EUR'));

        $sut = new Transaction(
            $localAccount,
            $remoteAccount,
            $purpose,
            $valutaDate,
            $date,
            $value
        );

        $this->assertEquals($localAccount, $sut->getLocalAccount());
        $this->assertEquals($remoteAccount, $sut->getRemoteAccount());
        $this->assertEquals($purpose, $sut->getPurpose());
        $this->assertEquals($valutaDate, $sut->getValutaDate());
        $this->assertEquals($date, $sut->getDate());
        $this->assertEquals($value, $sut->getValue());
    }
}

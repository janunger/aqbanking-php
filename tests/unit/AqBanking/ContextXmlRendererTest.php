<?php

namespace AqBanking;

use Money\Money;

class ContextXmlRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_render_transactions()
    {
        $fixture = file_get_contents(__DIR__ . '/fixtures/test_context_file_rendered.xml');
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($fixture);

        $sut = new ContextXmlRenderer($domDocument);

        $localAccount = new Account(new BankCode('50951469'), '12112345', 'Mustermann');
        $expectedTransactions = array(
            new Transaction(
                $localAccount,
                new Account(new BankCode('MALADE51KOB'), 'DE62570501200000012345', 'Sehr sehr langer Kontoinhab|ername'),
                '5828201 01.06.2013',
                new \DateTime('2013-06-03 12:00:00', new \DateTimeZone('UTC')),
                new \DateTime('2013-06-03 12:00:00', new \DateTimeZone('UTC')),
                Money::EUR(157740)
            ),
            new Transaction(
                $localAccount,
                new Account(new BankCode('50010060'), '12777914', 'Energieversorger XY'),
                'KNR. 9540395 88.00/ABSCHLAG|VOM 03.06.2013 570125/MUST|ERSTR. 1, 12345 MUSTERSTADT',
                new \DateTime('2013-06-04 12:00:00', new \DateTimeZone('UTC')),
                new \DateTime('2013-06-04 12:00:00', new \DateTimeZone('UTC')),
                Money::EUR(-8800)
            ),
            new Transaction(
                $localAccount,
                new Account(new BankCode('50961592'), '2531234', 'VEREIN XY'),
                'MITGLIEDSBEITRAG 2013',
                new \DateTime('2013-06-05 12:00:00', new \DateTimeZone('UTC')),
                new \DateTime('2013-06-05 12:00:00', new \DateTimeZone('UTC')),
                Money::EUR(-3800)
            ),
            new Transaction(
                $localAccount,
                new Account(new BankCode('50070010'), '175123456', 'PAYPAL'),
                'MHXA2O4A9O3HJ3PA PP*2240*PP|* VERKAEUFER X, IHR EINKAU|F BEI VERKAEUFER X, ARTIKEL|-125116343137|123456P3TX1234DT',
                new \DateTime('2013-06-07 12:00:00', new \DateTimeZone('UTC')),
                new \DateTime('2013-06-07 12:00:00', new \DateTimeZone('UTC')),
                Money::EUR(-3180)
            )
        );

        $this->assertEquals($expectedTransactions, $sut->getTransactions());
    }

    /**
     * @test
     */
    public function throws_exception_if_data_contains_reserved_char()
    {
        $fixture = file_get_contents(__DIR__ . '/fixtures/test_context_file_rendered_with_reserved_char.xml');
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($fixture);

        $sut = new ContextXmlRenderer($domDocument);

        $this->setExpectedException('\RuntimeException');
        $sut->getTransactions();
    }

    /**
     * @test
     */
    public function throws_exception_if_date_is_not_flagged_as_utc()
    {
        $fixture = file_get_contents(__DIR__ . '/fixtures/test_context_file_rendered_with_wrong_utc_flag.xml');
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($fixture);

        $sut = new ContextXmlRenderer($domDocument);

        $this->setExpectedException('\RuntimeException');
        $sut->getTransactions();
    }

    /**
     * @test
     */
    public function throws_exception_if_amount_is_malformed()
    {
        $fixture = file_get_contents(__DIR__ . '/fixtures/test_context_file_rendered_with_malformed_amount.xml');
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($fixture);

        $sut = new ContextXmlRenderer($domDocument);

        $this->setExpectedException('\RuntimeException');
        $sut->getTransactions();
    }
}

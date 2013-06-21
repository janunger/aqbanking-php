<?php

namespace AqBanking;

use Money\Money;

class ContextXmlRendererTest extends \PHPUnit_Framework_TestCase
{
    public function testCanRenderTransactions()
    {
        $fixture = file_get_contents(__DIR__ . '/fixtures/test_context_file_rendered.xml');
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($fixture);

        $sut = new ContextXmlRenderer($domDocument);

        $localAccount = new Account('50951469', '12112345', 'Mustermann');
        $expectedTransactions = array(
            new Transaction(
                $localAccount,
                new Account('MALADE51KOB', 'DE62570501200000012345', 'Sehr sehr langer Kontoinhab|ername'),
                '5828201 01.06.2013',
                new \DateTime('2013-06-03 12:00:00', new \DateTimeZone('UTC')),
                new \DateTime('2013-06-03 12:00:00', new \DateTimeZone('UTC')),
                Money::EUR(157740)
            ),
            new Transaction(
                $localAccount,
                new Account('50010060', '12777914', 'Energieversorger XY'),
                'KNR. 9540395 88.00/ABSCHLAG|VOM 03.06.2013 570125/MUST|ERSTR. 1, 12345 MUSTERSTADT',
                new \DateTime('2013-06-04 12:00:00', new \DateTimeZone('UTC')),
                new \DateTime('2013-06-04 12:00:00', new \DateTimeZone('UTC')),
                Money::EUR(-8800)
            ),
            new Transaction(
                $localAccount,
                new Account('50961592', '2531234', 'VEREIN XY'),
                'MITGLIEDSBEITRAG 2013',
                new \DateTime('2013-06-05 12:00:00', new \DateTimeZone('UTC')),
                new \DateTime('2013-06-05 12:00:00', new \DateTimeZone('UTC')),
                Money::EUR(-3800)
            ),
            new Transaction(
                $localAccount,
                new Account('50070010', '175123456', 'PAYPAL'),
                'MHXA2O4A9O3HJ3PA PP*2240*PP|* VERKAEUFER X, IHR EINKAU|F BEI VERKAEUFER X, ARTIKEL|-125116343137|123456P3TX1234DT',
                new \DateTime('2013-06-07 12:00:00', new \DateTimeZone('UTC')),
                new \DateTime('2013-06-07 12:00:00', new \DateTimeZone('UTC')),
                Money::EUR(-3180)
            )
        );

        $this->assertEquals($expectedTransactions, $sut->getTransactions());
    }
}

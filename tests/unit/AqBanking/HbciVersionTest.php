<?php

namespace AqBanking;

class HbciVersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_tell_if_higher_version_than_other_instance()
    {
        $sut = new HbciVersion('1.2.3');

        $equalVersion = new HbciVersion('1.2.2');
        $this->assertTrue($sut->isHigherThan($equalVersion));

        $equalVersion = new HbciVersion('1.2.3');
        $this->assertFalse($sut->isHigherThan($equalVersion));

        $higherVersion = new HbciVersion('1.2.4');
        $this->assertFalse($sut->isHigherThan($higherVersion));
    }

    /**
     * @test
     */
    public function is_higher_than_null()
    {
        $sut = new HbciVersion('1.2.3');

        $this->assertTrue($sut->isHigherThan(null));
    }

    /**
     * @test
     */
    public function can_have_method_code()
    {
        $methodCode = '1234';

        $sut = new HbciVersion('1.2.3', $methodCode);

        $this->assertEquals($methodCode, $sut->getMethodCode());
    }
}

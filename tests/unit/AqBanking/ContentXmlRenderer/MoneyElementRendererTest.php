<?php

namespace AqBanking\ContentXmlRenderer;

use Money\Money;

class MoneyElementRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_render_0_euro()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(0);
        $this->assertEquals($expected, $sut->render('0/100', 'EUR'));
    }

    /**
     * @test
     */
    public function can_render_1_euro()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(100);
        $this->assertEquals($expected, $sut->render('100/100', 'EUR'));
    }

    /**
     * @test
     */
    public function can_render_minus_1_euro()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(-100);
        $this->assertEquals($expected, $sut->render('-100/100', 'EUR'));
    }

    /**
     * @test
     */
    public function can_render_10_euros()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(1000);
        $this->assertEquals($expected, $sut->render('1000/100', 'EUR'));
    }

    /**
     * @test
     */
    public function can_render_100_euros()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(10000);
        $this->assertEquals($expected, $sut->render('10000/100', 'EUR'));
    }

    /**
     * @test
     */
    public function can_render_1_swiss_franc()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::CHF(100);
        $this->assertEquals($expected, $sut->render('100/100', 'CHF'));
    }

    /**
     * @test
     * @see https://github.com/janunger/aqbanking-php/issues/1
     */
    public function can_render_with_10_as_divisor()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(67890);
        $this->assertEquals($expected, $sut->render('6789/10', 'EUR'));
    }

    /**
     * @test
     */
    public function can_render_with_1000_as_divisor()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(6789);
        $this->assertEquals($expected, $sut->render('67890/1000', 'EUR'));
    }

    /**
     * @test
     */
    public function can_render_with_1_as_divisor()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(678900);
        $this->assertEquals($expected, $sut->render('6789/1', 'EUR'));
    }

    /**
     * @test
     * @see https://github.com/janunger/aqbanking-php/issues/1
     */
    public function can_render_without_an_explicit_divisor()
    {
        $sut = new MoneyElementRenderer();

        $expected = Money::EUR(678900);
        $this->assertEquals($expected, $sut->render('6789', 'EUR'));
    }

    /**
     * @test
     */
    public function throws_exception_on_unexpected_divisor()
    {
        $sut = new MoneyElementRenderer();

        $this->setExpectedException('\AqBanking\RuntimeException');
        $sut->render('200/200', 'EUR');
    }

    /**
     * @test
     */
    public function throws_exception_if_amount_is_biassed_on_transformation()
    {
        $sut = new MoneyElementRenderer();

        $this->setExpectedException('\AqBanking\RuntimeException', 'Biassed rendering result');
        $sut->render('1234/1000', 'EUR');
    }

    /**
     * @test
     */
    public function throws_exception_on_unknown_currency()
    {
        $sut = new MoneyElementRenderer();

        $this->setExpectedException('\AqBanking\RuntimeException');
        $sut->render('1/100', 'XXX');
    }

    /**
     * @test
     */
    public function throws_exception_on_invalid_amount()
    {
        $sut = new MoneyElementRenderer();

        $this->setExpectedException('\AqBanking\RuntimeException');
        $sut->render('/100', 'EUR');
    }
}

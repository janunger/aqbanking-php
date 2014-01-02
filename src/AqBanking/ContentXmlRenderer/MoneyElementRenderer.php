<?php

namespace AqBanking\ContentXmlRenderer;

use AqBanking\RuntimeException;
use Money\Currency;
use Money\Money;
use Money\UnknownCurrencyException;

class MoneyElementRenderer
{
    /**
     * @param string $value
     * @param string $currencyString
     * @throws \AqBanking\RuntimeException
     * @return Money
     */
    public function render($value, $currencyString)
    {
        try {
            $currency = new Currency($currencyString);
        } catch (UnknownCurrencyException $e) {
            throw new RuntimeException("Unknown currency input '$currencyString'");
        }

        $amount = $this->normalizeAmount($value);

        return new Money($amount, $currency);
    }

    /**
     * @see https://github.com/janunger/aqbanking-php/issues/1
     *
     * @param string $value
     * @throws \AqBanking\RuntimeException
     * @return int
     */
    private function normalizeAmount($value)
    {
        list ($amount, $divisor) = $this->extractAmountAndDivisorAsString($value);

        $multiplier = 100/(int)$divisor;
        $normalizedAmount = (int)$amount * $multiplier;

        if ($this->isNormalizedValueBiassed($normalizedAmount)) {
            throw new RuntimeException(
                "Biassed rendering result '$normalizedAmount' from amount '$amount' and divisor '$divisor'"
            );
        }

        return (int)$normalizedAmount;
    }

    /**
     * @param $amountString
     * @return array
     * @throws \AqBanking\RuntimeException
     */
    private function extractAmountAndDivisorAsString($amountString)
    {
        $matches = array();
        if (preg_match('/^(?P<amount>(-){0,1}\d+)\/(?P<divisor>1(0)*)$/', $amountString, $matches)) {
            $amount = $matches['amount'];
            $divisor = $matches['divisor'];

            return array($amount, $divisor);
        }

        $matches = array();
        if (preg_match('/^(?P<amount>(-){0,1}\d+)$/', $amountString, $matches)) {
            $amount = $matches['amount'];

            return array($amount, '1');
        }

        throw new RuntimeException("Unexpected amount input '$amountString'");
    }

    /**
     * @param mixed $normalizedAmount
     * @return bool
     */
    private function isNormalizedValueBiassed($normalizedAmount)
    {
        return $normalizedAmount != (int)$normalizedAmount;
    }
}

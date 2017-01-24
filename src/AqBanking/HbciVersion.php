<?php

namespace AqBanking;

class HbciVersion
{
    /**
     * @var string
     */
    private $versionNumber;

    /**
     * @var string|null
     */
    private $methodCode;

    /**
     * @param string $versionNumber
     * @param string|null $methodCode
     */
    public function __construct($versionNumber, $methodCode = null)
    {
        $this->versionNumber = $versionNumber;
        $this->methodCode = $methodCode;
    }

    /**
     * @param HbciVersion $hbciVersion
     * @return bool
     */
    public function isHigherThan(HbciVersion $hbciVersion = null)
    {
        if (null === $hbciVersion) {
            return true;
        }

        return (version_compare($this->versionNumber, $hbciVersion->versionNumber) > 0);
    }

    /**
     * @return string|null
     */
    public function getMethodCode()
    {
        return $this->methodCode;
    }

    /**
     * @return string
     */
    public function getVersionNumber()
    {
        return $this->versionNumber;
    }
}

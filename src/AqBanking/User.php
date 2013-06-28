<?php

namespace AqBanking;

class User
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var Bank
     */
    private $bank;

    /**
     * @param string $userId
     * @param string $userName
     * @param Bank $bank
     */
    public function __construct($userId, $userName, Bank $bank)
    {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->bank = $bank;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return Bank
     */
    public function getBank()
    {
        return $this->bank;
    }
}

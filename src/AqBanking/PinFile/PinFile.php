<?php

namespace AqBanking\PinFile;

use AqBanking\User;

class PinFile implements PinFileInterface
{
    /**
     * @var string
     */
    private $dir;

    /**
     * @var User
     */
    private $user;

    public function __construct($dir, User $user)
    {
        $this->user = $user;
        $this->dir = $dir;
    }

    public function getFileName()
    {
        return sprintf(
            'pinfile_%s_%s',
            $this->user->getBank()->getBankCode()->getString(),
            $this->user->getUserId()
        );
    }

    public function getPath()
    {
        return $this->dir . '/' . $this->getFileName();
    }
}

<?php

namespace AqBanking\PinFile;

interface PinFileInterface
{
    /**
     * @return string
     */
    public function getFileName();

    /**
     * @return string
     */
    public function getPath();
}

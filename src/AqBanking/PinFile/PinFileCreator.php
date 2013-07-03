<?php

namespace AqBanking\PinFile;

use AqBanking\PinFile\PinFile;
use AqBanking\User;
use Assert\Assertion;

class PinFileCreator
{
    /**
     * @var string
     */
    private $pinFileDir;

    public function __construct($pinFileDir)
    {
        $this->pinFileDir = $pinFileDir;
    }

    /**
     * @param string $pin
     * @param User $user
     * @return PinFile
     */
    public function createFile($pin, User $user)
    {
        Assertion::directory($this->pinFileDir);
        Assertion::writeable($this->pinFileDir);

        $pinFile = new PinFile($this->pinFileDir, $user);
        $bankCodeString = $user->getBank()->getBankCode()->getString();
        $userId = $user->getUserId();

        // The comments and line breaks seem to be mandatory for AqBanking to parse the file
        $fileContent =
            '# This is a PIN file to be used with AqBanking' . PHP_EOL
            . '# Please insert the PINs/passwords for the users below' . PHP_EOL
            . PHP_EOL
            . '# User "' . $userId . '" at "' . $bankCodeString . '"' . PHP_EOL
            . 'PIN_' . $bankCodeString . '_' . $userId . ' = "' . $pin . '"' . PHP_EOL
        ;
        $filePath = $pinFile->getPath();

        file_put_contents($filePath, $fileContent);

        return $pinFile;
    }
}

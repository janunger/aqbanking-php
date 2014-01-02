<?php

namespace AqBanking\PinFile;

use AqBanking\User;

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
        $pinFileDir = $this->pinFileDir;

        $this->assertIsWritableDir($pinFileDir);

        $pinFile = new PinFile($pinFileDir, $user);
        $filePath = $pinFile->getPath();
        $fileContent = $this->createFileContent(
            $pin,
            $user->getUserId(),
            $user->getBank()->getBankCode()->getString()
        );

        file_put_contents($filePath, $fileContent);

        return $pinFile;
    }

    /**
     * @param string $pinFileDir
     * @throws \InvalidArgumentException
     */
    private function assertIsWritableDir($pinFileDir)
    {
        if (!is_dir($pinFileDir)) {
            throw new \InvalidArgumentException("PIN file dir '$pinFileDir' is not a directory");
        }
        if (!is_writable($pinFileDir)) {
            throw new \InvalidArgumentException("PIN file dir '$pinFileDir' is not writable");
        }
    }

    /**
     * @param string $pin
     * @param string $userId
     * @param string $bankCodeString
     * @return string
     */
    private function createFileContent($pin, $userId, $bankCodeString)
    {
        // The comments and line breaks seem to be mandatory for AqBanking to parse the file
        return
            '# This is a PIN file to be used with AqBanking' . PHP_EOL
            . '# Please insert the PINs/passwords for the users below' . PHP_EOL
            . PHP_EOL
            . '# User "' . $userId . '" at "' . $bankCodeString . '"' . PHP_EOL
            . 'PIN_' . $bankCodeString . '_' . $userId . ' = "' . $pin . '"' . PHP_EOL;
    }
}

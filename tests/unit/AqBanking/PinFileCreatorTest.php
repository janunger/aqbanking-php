<?php

namespace AqBanking;

use AqBanking\PinFile\PinFileCreator;
use org\bovigo\vfs\vfsStream;

class PinFileCreatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateValidPinFiles()
    {
        $pinFileDir = 'someDir';
        $vfsRoot = vfsStream::setup($pinFileDir);
        $pinFileDirMock = vfsStream::url($pinFileDir);

        $pin = '12345';
        $userId = 'mustermann';
        $bankCodeString = '12345678';
        $user = new User($userId, 'Max Mustermann', new Bank(new BankCode($bankCodeString), 'https://hbci.example.com'));

        $expectedFileName = 'pinfile_' . $bankCodeString . '_' . $userId;

        $sut = new PinFileCreator();

        $this->assertFalse($vfsRoot->hasChild($expectedFileName));

        $pinFile = $sut->createFile($pinFileDirMock, $pin, $user);

        $this->assertTrue($vfsRoot->hasChild($expectedFileName));
        $this->assertEquals($expectedFileName, $pinFile->getFileName());

        $expectedContent =
            '# This is a PIN file to be used with AqBanking' . PHP_EOL
            . '# Please insert the PINs/passwords for the users below' . PHP_EOL
            . PHP_EOL
            . '# User "' . $userId . '" at "' . $bankCodeString . '"' . PHP_EOL
            . 'PIN_' . $bankCodeString . '_' . $userId . ' = "' . $pin . '"' . PHP_EOL;

        $this->assertEquals($expectedContent, file_get_contents($pinFileDirMock . '/' . $expectedFileName));
    }
}

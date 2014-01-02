<?php

namespace AqBanking;

use AqBanking\PinFile\PinFileCreator;
use org\bovigo\vfs\vfsStream;

class PinFileCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function creates_valid_pin_files()
    {
        $pinFileDir = 'someDir';
        $vfsRoot = vfsStream::setup($pinFileDir);
        $pinFileDirMock = vfsStream::url($pinFileDir);

        $pin = '12345';
        $userId = 'mustermann';
        $bankCodeString = '12345678';
        $user = new User($userId, 'Max Mustermann', new Bank(new BankCode($bankCodeString), 'https://hbci.example.com'));

        $expectedFileName = 'pinfile_' . $bankCodeString . '_' . $userId;

        $sut = new PinFileCreator($pinFileDirMock);

        $this->assertFalse($vfsRoot->hasChild($expectedFileName));

        $pinFile = $sut->createFile($pin, $user);

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

    /**
     * @test
     */
    public function throws_exception_if_given_pin_file_dir_is_not_a_directory()
    {
        $sut = new PinFileCreator('/no/such/dir');

        $this->setExpectedException('\InvalidArgumentException', 'is not a directory');
        $sut->createFile('12345', $this->createDummyUser());
    }

    /**
     * @test
     */
    public function throws_exception_if_given_pin_file_dir_is_not_writable()
    {
        $pinFileDir = 'someDir';
        vfsStream::setup($pinFileDir, 0555);
        $pinFileDirMock = vfsStream::url($pinFileDir);

        $sut = new PinFileCreator($pinFileDirMock);

        $this->setExpectedException('\InvalidArgumentException', 'is not writable');
        $sut->createFile('12345', $this->createDummyUser());
    }

    /**
     * @return User
     */
    private function createDummyUser()
    {
        return new User('mustermann', 'Max Mustermann', new Bank(new BankCode('12345678'), 'https://hbci.example.com'));
    }
}

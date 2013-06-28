<?php

namespace AqBanking\Command;

use AqBanking\Bank;
use AqBanking\BankCode;
use AqBanking\Command\ShellCommandExecutor\Result;
use AqBanking\PinFile;
use AqBanking\User;

class GetSysIDCommandTest extends ShellCommandTestCase
{
    public function testPollsSysID()
    {
        $userId = 'mustermann';
        $userName = 'Max Mustermann';
        $bankCodeString = '12345678';
        $hbciUrl = 'https://hbci.example.com';

        $bankCode = new BankCode($bankCodeString);
        $bank = new Bank($bankCode, $hbciUrl);
        $user = new User($userId, $userName, $bank);
        $pinFile = new PinFile('/path/to/pinfile/dir', $user);

        $shellCommandExecutorMock = $this->getShellCommandExecutorMock();

        $expectedCommand =
            'aqhbci-tool4'
            . ' --pinfile=' . $pinFile->getPath()
            . ' --noninteractive'
            . ' --acceptvalidcerts'
            . ' getsysid'
            . ' --bank=' . $bankCodeString
            . ' --user=' . $userId
        ;

        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand)
            ->andReturn(new Result(array(), array(), 0));

        $sut = new GetSysIDCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute($user, $pinFile);

        // To satisfy PHPUnit's "strict" mode - if Mockery didn't throw an exception until here, everything is fine
        $this->assertTrue(true);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testThrowsExceptionOnUnexpectedResult()
    {
        $userId = 'mustermann';
        $userName = 'Max Mustermann';
        $bankCodeString = '12345678';
        $hbciUrl = 'https://hbci.example.com';

        $bankCode = new BankCode($bankCodeString);
        $bank = new Bank($bankCode, $hbciUrl);
        $user = new User($userId, $userName, $bank);
        $pinFile = new PinFile('/path/to/pinfile/dir', $user);

        $shellCommandExecutorMock = $this->getShellCommandExecutorMock();

        $expectedCommand =
            'aqhbci-tool4'
            . ' --pinfile=' . $pinFile->getPath()
            . ' --noninteractive'
            . ' --acceptvalidcerts'
            . ' getsysid'
            . ' --bank=' . $bankCodeString
            . ' --user=' . $userId
        ;

        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand)
            ->andReturn(new Result(array(), array(), 1));

        $sut = new GetSysIDCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute($user, $pinFile);
    }
}

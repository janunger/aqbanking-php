<?php

namespace AqBanking\Command;

use AqBanking\Bank;
use AqBanking\BankCode;
use AqBanking\Command\ShellCommandExecutor\Result;
use AqBanking\User;

require_once 'ShellCommandTestCase.php';

class AddUserCommandTest extends ShellCommandTestCase
{
    public function testCanAddAqBankingUser()
    {
        $userId = 'mustermann';
        $userName = 'Max Mustermann';
        $bankCodeString = '12345678';
        $hbciUrl = 'https://hbci.example.com';

        $bankCode = new BankCode($bankCodeString);
        $bank = new Bank($bankCode, $hbciUrl);
        $user = new User($userId, $userName, $bank);

        $shellCommandExecutorMock = $this->getShellCommandExecutorMock();

        $expectedCommand =
            'aqhbci-tool4'
            . ' adduser'
            . ' --username="' . $userName . '"'
            . ' --bank=' . $bankCodeString
            . ' --user=' . $userId
            . ' --tokentype=pintan'
            . ' --server=' . $hbciUrl
        ;

        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand)
            ->andReturn(new Result(array(), array(), 0));

        $sut = new AddUserCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);

        $sut->execute($user);

        // To satisfy PHPUnit's "strict" mode - if Mockery didn't throw an exception until here, everything is fine
        $this->assertTrue(true);
    }

    /**
     * @expectedException \AqBanking\Command\AddUserCommand\UserAlreadyExistsException
     */
    public function testThrowsExceptionIfUserAlreadyExists()
    {
        $userId = 'mustermann';
        $userName = 'Max Mustermann';
        $bankCodeString = '12345678';
        $hbciUrl = 'https://hbci.example.com';

        $shellCommandExecutorMock = $this->getShellCommandExecutorMock();

        $expectedCommand =
            'aqhbci-tool4'
            . ' adduser'
            . ' --username="' . $userName . '"'
            . ' --bank=' . $bankCodeString
            . ' --user=' . $userId
            . ' --tokentype=pintan'
            . ' --server=' . $hbciUrl
        ;

        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand)
            ->andReturn(new Result(array(), array(), AddUserCommand::RETURN_VAR_USER_ALREADY_EXISTS));

        $sut = new AddUserCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);

        $sut->execute(new User($userId, $userName, new Bank(new BankCode($bankCodeString), $hbciUrl)));
    }

    /**
     * @expectedException \AqBanking\Command\ShellCommandExecutor\DefectiveResultException
     */
    public function testThrowsExceptionOnUnexpectedResult()
    {
        $userId = 'mustermann';
        $userName = 'Max Mustermann';
        $bankCodeString = '12345678';
        $hbciUrl = 'https://hbci.example.com';

        $shellCommandExecutorMock = $this->getShellCommandExecutorMock();

        $expectedCommand =
            'aqhbci-tool4'
            . ' adduser'
            . ' --username="' . $userName . '"'
            . ' --bank=' . $bankCodeString
            . ' --user=' . $userId
            . ' --tokentype=pintan'
            . ' --server=' . $hbciUrl
        ;

        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand)
            ->andReturn(new Result(array(), array(), 127));

        $sut = new AddUserCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);

        $sut->execute(new User($userId, $userName, new Bank(new BankCode($bankCodeString), $hbciUrl)));
    }
}

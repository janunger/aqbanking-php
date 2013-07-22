<?php

namespace AqBanking\Command;

use AqBanking\Account;
use AqBanking\BankCode;
use AqBanking\Command\ShellCommandExecutor\Result;
use AqBanking\ContextFile;
use AqBanking\PinFile\PinFile;
use AqBanking\User;

require_once 'ShellCommandTestCase.php';

class RequestCommandTest extends ShellCommandTestCase
{
    public function testCanExecute()
    {
        $accountNumber = '12345678';
        $bankCodeString = '23456789';
        $bankCode = new BankCode($bankCodeString);
        $account = new Account($bankCode, $accountNumber);

        $pathToContextFile = '/path/to/context_file';
        $contextFile = new ContextFile($pathToContextFile);

        $pathToPinFile = '/path/to/pinfile';
        $pinFileMock = $this->getPinFileMock($pathToPinFile);

        $shellCommandExecutorMock = $this->getShellCommandExecutorMock();
        // This is the actual test
        $expectedCommand =
            "aqbanking-cli"
            . " --noninteractive"
            . " --acceptvalidcerts"
            . " --pinfile=" . $pathToPinFile
            . " request"
            . " --bank=" . $bankCodeString
            . " --account=" . $accountNumber
            . " --ctxfile=" . $pathToContextFile
            . " --transactions"
            . " --balance"
            . " --sto"
            . " --dated";
        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand)
            ->andReturn(new Result(array(), array(), 0));

        $sut = new RequestCommand($account, $contextFile, $pinFileMock);
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute();

        // To satisfy PHPUnit's "strict" mode - if Mockery didn't throw an exception until here, everything is fine
        $this->assertTrue(true);
    }

    public function testCanExecuteWithFromDate()
    {
        $accountNumber = '12345678';
        $bankCodeString = '23456789';
        $bankCode = new BankCode($bankCodeString);
        $account = new Account($bankCode, $accountNumber);

        $pathToContextFile = '/path/to/context_file';
        $contextFile = new ContextFile($pathToContextFile);

        $pathToPinFile = '/path/to/pinfile';
        $pinFileMock = $this->getPinFileMock($pathToPinFile);

        $fromDate = new \DateTime('yesterday');

        $shellCommandExecutorMock = $this->getShellCommandExecutorMock();
        // This is the actual test
        $expectedCommand =
            "aqbanking-cli"
            . " --noninteractive"
            . " --acceptvalidcerts"
            . " --pinfile=" . $pathToPinFile
            . " request"
            . " --bank=" . $bankCodeString
            . " --account=" . $accountNumber
            . " --ctxfile=" . $pathToContextFile
            . " --transactions"
            . " --balance"
            . " --sto"
            . " --dated"
            . " --fromdate=" . $fromDate->format('Ymd');
        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand)
            ->andReturn(new Result(array(), array(), 0));

        $sut = new RequestCommand($account, $contextFile, $pinFileMock);
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute($fromDate);

        // To satisfy PHPUnit's "strict" mode - if Mockery didn't throw an exception until here, everything is fine
        $this->assertTrue(true);
    }

    /**
     * @expectedException \AqBanking\Command\ShellCommandExecutor\DefectiveResultException
     */
    public function testThrowsExceptionOnUnexpectedResult()
    {
        $accountNumber = '12345678';
        $bankCodeString = '23456789';
        $bankCode = new BankCode($bankCodeString);
        $account = new Account($bankCode, $accountNumber);

        $pathToContextFile = '/path/to/context_file';
        $contextFile = new ContextFile($pathToContextFile);

        $pathToPinFile = '/path/to/pinfile';
        $pinFileMock = $this->getPinFileMock($pathToPinFile);

        $shellCommandExecutorMock = $this->getShellCommandExecutorMock();
        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->andReturn(new Result(array(), array('some unexpected output'), 0));

        $sut = new RequestCommand($account, $contextFile, $pinFileMock);
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute();
    }

    /**
     * @param string $pathToPinFile
     * @return \Mockery\MockInterface
     */
    private function getPinFileMock($pathToPinFile)
    {
        $pinFileMock = \Mockery::mock('AqBanking\PinFile\PinFile');
        $pinFileMock
            ->shouldReceive('getPath')
            ->andReturn($pathToPinFile);

        return $pinFileMock;
    }
}

<?php

namespace AqBanking\Command;

use AqBanking\Account;
use AqBanking\Bank;

class RequestCommandTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
    }

    public function testCanExecute()
    {
        $accountNumber = '12345678';
        $bankCode = '23456789';
        $account = new Account(new Bank($bankCode), $accountNumber);

        $pathToContextFile = '/path/to/context_file';
        $contextFile = new ContextFile($pathToContextFile);

        $pathToPinList = '/path/to/pinlist';

        $shellCommandExecutorMock = \Mockery::mock('AqBanking\Command\ShellCommandExecutor');
        // This is the actual test
        $expectedCommand =
            "aqbanking-cli"
            . " --noninteractive"
            . " --acceptvalidcerts"
            . " --pinfile=" . $pathToPinList
            . " request"
            . " --bank=" . $bankCode
            . " --account=" . $accountNumber
            . " --ctxfile=" . $pathToContextFile
            . " --transactions"
            . " --balance"
            . " --sto"
            . " --dated"
        ;
        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand);
            //->andReturn(new Result(array(), 0));

        $sut = new RequestCommand($account, $contextFile, $pathToPinList);
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute();

        // To satisfy PHPUnit's "strict" mode - if Mockery didn't throw an exception until here, everything is fine
        $this->assertTrue(true);
    }

    public function testCanExecuteWithFromDate()
    {
        $accountNumber = '12345678';
        $bankCode = '23456789';
        $account = new Account(new Bank($bankCode), $accountNumber);

        $pathToContextFile = '/path/to/context_file';
        $contextFile = new ContextFile($pathToContextFile);

        $pathToPinList = '/path/to/pinlist';

        $fromDate = new \DateTime('yesterday');

        $shellCommandExecutorMock = \Mockery::mock('AqBanking\Command\ShellCommandExecutor');
        // This is the actual test
        $expectedCommand =
            "aqbanking-cli"
            . " --noninteractive"
            . " --acceptvalidcerts"
            . " --pinfile=" . $pathToPinList
            . " request"
            . " --bank=" . $bankCode
            . " --account=" . $accountNumber
            . " --ctxfile=" . $pathToContextFile
            . " --transactions"
            . " --balance"
            . " --sto"
            . " --dated"
            . " --fromdate=" . $fromDate->format('Ymd')
        ;
        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand);
            //->andReturn(new Result(array(), 0));

        $sut = new RequestCommand($account, $contextFile, $pathToPinList);
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute($fromDate);

        // To satisfy PHPUnit's "strict" mode - if Mockery didn't throw an exception until here, everything is fine
        $this->assertTrue(true);
    }
}

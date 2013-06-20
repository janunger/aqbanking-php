<?php

namespace AqBanking\Command;

use AqBanking\Command\ShellCommandExecutor\Result;

class CheckAqBankingCommandTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
    }

    public function testCanTellIfAqBankingIsInstalled()
    {
        $shellCommandExecutorMock = \Mockery::mock('AqBanking\Command\ShellCommandExecutor');
        $shellCommandExecutorMock
            ->shouldReceive('execute')
            ->with('aqbanking-cli --help')
            ->andReturn(new Result(array(), array(), 0));
        $shellCommandExecutorMock
            ->shouldReceive('execute')
            ->with('aqbanking-config --vstring')
            ->andReturn(new Result(array('5.0.24'), array(), 0));

        $sut = new CheckAqBankingCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute();

        // To satisfy PHPUnit's "strict" mode - if Mockery didn't throw an exception until here, everything is fine
        $this->assertTrue(true);
    }

    /**
     * @expectedException \AqBanking\Command\CheckAqBankingCommand\AqBankingNotRespondingException
     */
    public function testCanTellIfAqBankingIsNotInstalled()
    {
        $shellCommandExecutorMock = \Mockery::mock('AqBanking\Command\ShellCommandExecutor');
        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with('aqbanking-cli --help')
            ->andReturn(new Result(array(), array(), 127));

        $sut = new CheckAqBankingCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute();
    }

    /**
     * @expectedException \AqBanking\Command\CheckAqBankingCommand\AqBankingVersionTooOldException
     */
    public function testCanTellIfAqBankingVersionIsTooOld()
    {
        $shellCommandExecutorMock = \Mockery::mock('AqBanking\Command\ShellCommandExecutor');
        $shellCommandExecutorMock
            ->shouldReceive('execute')
            ->with('aqbanking-cli --help')
            ->andReturn(new Result(array(), array(), 0));
        $shellCommandExecutorMock
            ->shouldReceive('execute')
            ->with('aqbanking-config --vstring')
            ->andReturn(new Result(array('5.0.23'), array(), 0));

        $sut = new CheckAqBankingCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);
        $sut->execute();
    }
}

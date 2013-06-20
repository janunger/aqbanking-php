<?php

namespace AqBanking\Command;

use AqBanking\Command\ShellCommandExecutor\Result;
use AqBanking\ContextFile;

class RenderContextFileToXMLCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCanIssueCorrectRenderCommand()
    {
        $contextFile = new ContextFile('/path/to/some/context/file.ctx');

        $shellCommandExecutorMock = \Mockery::mock('AqBanking\Command\ShellCommandExecutor');
        $expectedCommand =
            'aqbanking-cli'
            . ' listtrans'
            . ' --ctxfile=' . $contextFile->getPath()
            . ' --exporter=xmldb';
        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->with($expectedCommand)
            ->andReturn(new Result(array(), array(), 0));

        $sut = new RenderContextFileToXMLCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);

        $sut->execute($contextFile);

        // To satisfy PHPUnit's "strict" mode - if Mockery didn't throw an exception until here, everything is fine
        $this->assertTrue(true);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanHandleUnexpectedOutput()
    {
        $shellCommandExecutorMock = \Mockery::mock('AqBanking\Command\ShellCommandExecutor');
        $shellCommandExecutorMock
            ->shouldReceive('execute')->once()
            ->andReturn(new Result(array(), array(), 1));

        $sut = new RenderContextFileToXMLCommand();
        $sut->setShellCommandExecutor($shellCommandExecutorMock);

        $sut->execute(new ContextFile('/path/to/some/context/file.ctx'));
    }
}

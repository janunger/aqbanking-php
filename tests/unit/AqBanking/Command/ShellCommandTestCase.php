<?php

namespace AqBanking\Command;

class ShellCommandTestCase extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @return \Mockery\MockInterface
     */
    protected function getShellCommandExecutorMock()
    {
        return \Mockery::mock('AqBanking\Command\ShellCommandExecutor');
    }
}

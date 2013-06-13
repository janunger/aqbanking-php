<?php

namespace AqBanking\Command;

class ShellCommandExecutorTest extends \PHPUnit_Framework_TestCase
{
    public function testCanExecuteCommand()
    {
        $sut = new ShellCommandExecutor();

        $result = $sut->execute('echo "whatever"');

        $this->assertEquals(array("whatever"), $result->getOutput());
        $this->assertEquals(array(), $result->getErrors());
        $this->assertEquals(0, $result->getReturnVar());
    }

    public function testCanTellAboutErrors()
    {
        $sut = new ShellCommandExecutor();

        $result = $sut->execute("any-unknown-command");

        $this->assertEquals(array(), $result->getOutput());
        $this->assertNotEquals(0, count($result->getErrors()));
        $this->assertNotEquals(0, $result->getReturnVar());
    }
}

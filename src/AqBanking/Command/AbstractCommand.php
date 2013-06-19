<?php

namespace AqBanking\Command;

abstract class AbstractCommand
{
    /**
     * @var null|ShellCommandExecutor
     */
    private $shellCommandExecutor = null;

    public function setShellCommandExecutor(ShellCommandExecutor $shellCommandExecutor)
    {
        $this->shellCommandExecutor = $shellCommandExecutor;
    }

    /**
     * @return ShellCommandExecutor
     */
    protected function getShellCommandExecutor()
    {
        if (null === $this->shellCommandExecutor) {
            $this->shellCommandExecutor = new ShellCommandExecutor();
        }

        return $this->shellCommandExecutor;
    }
}

<?php

namespace AqBanking\Command;

abstract class AbstractCommand
{
    /**
     * @var null|ShellCommandExecutor
     */
    private $shellCommandExecutor = null;

    /**
     * @var string
     */
    protected $pathToAqBankingCLIBinary = 'aqbanking-cli';

    /**
     * @var string
     */
    protected $pathToAqBankingConfigBinary = 'aqbanking-config';

    /**
     * @param ShellCommandExecutor $shellCommandExecutor
     */
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

    /**
     * @param string $binaryPath
     */
    public function setPathToAqBankingCLIBinary($binaryPath)
    {
        $this->pathToAqBankingCLIBinary = $binaryPath;
    }

    /**
     * @param string $pathToAqBankingConfigBinary
     */
    public function setPathToAqBankingConfigBinary($pathToAqBankingConfigBinary)
    {
        $this->pathToAqBankingConfigBinary = $pathToAqBankingConfigBinary;
    }
}

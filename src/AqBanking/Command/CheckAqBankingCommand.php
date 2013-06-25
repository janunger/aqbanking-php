<?php

namespace AqBanking\Command;

use AqBanking\Command\CheckAqBankingCommand\AqBankingNotRespondingException;
use AqBanking\Command\CheckAqBankingCommand\AqBankingVersionTooOldException;

class CheckAqBankingCommand extends AbstractCommand
{
    public function execute()
    {
        $this->assertAqBankingResponds();
        $this->assertAqBankingIsAppropriateVersion();
    }

    private function assertAqBankingResponds()
    {
        $shellCommand = $this->pathToAqBankingCLIBinary . ' --help';
        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        if (0 !== $result->getReturnVar()) {
            throw new AqBankingNotRespondingException();
        }
    }

    private function assertAqBankingIsAppropriateVersion()
    {
        $minVersion = '5.0.24';
        $shellCommand = $this->pathToAqBankingConfigBinary . ' --vstring';
        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        if (0 !== $result->getReturnVar()) {
            throw new AqBankingVersionTooOldException(
                'Required version: ' . $minVersion . ' - present version: unknown');
        }

        $versionString = $result->getOutput()[0];
        if (version_compare($versionString, $minVersion) < 0) {
            throw new AqBankingVersionTooOldException(
                'Required version: ' . $minVersion . ' - present version: ' . $versionString);
        }
    }
}

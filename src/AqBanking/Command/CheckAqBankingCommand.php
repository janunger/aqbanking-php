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
        $shellCommand = 'aqbanking-cli --help';
        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        if (0 !== $result->getReturnVar()) {
            throw new AqBankingNotRespondingException();
        }
    }

    private function assertAqBankingIsAppropriateVersion()
    {
        $shellCommand = 'aqbanking-config --vstring';
        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        if (0 !== $result->getReturnVar()) {
            throw new AqBankingVersionTooOldException();
        }

        $versionString = $result->getOutput()[0];
        $minVersion = '5.0.24';
        if (version_compare($versionString, $minVersion) < 0) {
            throw new AqBankingVersionTooOldException();
        }
    }
}

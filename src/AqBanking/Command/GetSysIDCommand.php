<?php

namespace AqBanking\Command;

use AqBanking\PinFile\PinFile;
use AqBanking\User;

class GetSysIDCommand extends AbstractCommand
{
    public function execute(User $user, PinFile $pinFile)
    {
        $shellCommand =
            $this->pathToAqHBCIToolBinary
            . ' --pinfile=' . escapeshellcmd($pinFile->getPath())
            . ' --noninteractive'
            . ' --acceptvalidcerts'
            . ' getsysid'
            . ' --bank=' . escapeshellcmd($user->getBank()->getBankCode()->getString())
            . ' --user=' . escapeshellcmd($user->getUserId())
        ;

        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        if (0 !== $result->getReturnVar()) {
            throw new \RuntimeException(implode(PHP_EOL, $result->getErrors()));
        }
    }
}

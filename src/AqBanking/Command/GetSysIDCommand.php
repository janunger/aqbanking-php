<?php

namespace AqBanking\Command;

use AqBanking\PinFile;
use AqBanking\User;

class GetSysIDCommand extends AbstractCommand
{
    public function execute(User $user, PinFile $pinFile)
    {
        $shellCommand =
            $this->pathToAqHBCIToolBinary
            . ' --pinfile=' . $pinFile->getPath()
            . ' --noninteractive'
            . ' --acceptvalidcerts'
            . ' getsysid'
            . ' --bank=' . $user->getBank()->getBankCode()->getString()
            . ' --user=' . $user->getUserId()
        ;

        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        // TODO: Error handling
        if (0 !== $result->getReturnVar()) {
            throw new \RuntimeException(implode(PHP_EOL, $result->getErrors()));
        }
    }
}

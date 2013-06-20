<?php

namespace AqBanking\Command;

use AqBanking\ContextFile;

class RenderContextFileToXMLCommand extends AbstractCommand
{
    public function execute(ContextFile $contextFile)
    {
        $shellCommand =
            'aqbanking-cli'
            . ' listtrans'
            . ' --ctxfile=' . $contextFile->getPath()
            . ' --exporter=xmldb';

        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        if ($result->getReturnVar() !== 0) {
            throw new \RuntimeException(
                'AqBanking exited with errors: ' . PHP_EOL
                . implode(PHP_EOL, $result->getErrors())
            );
        }

        return implode(PHP_EOL, $result->getOutput());
    }
}

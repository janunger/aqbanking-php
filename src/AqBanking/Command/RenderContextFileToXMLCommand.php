<?php

namespace AqBanking\Command;

use AqBanking\ContextFile;

class RenderContextFileToXMLCommand extends AbstractCommand
{
    /**
     * @param ContextFile $contextFile
     * @return \DOMDocument
     * @throws \RuntimeException
     */
    public function execute(ContextFile $contextFile)
    {
        $shellCommand =
            $this->pathToAqBankingCLIBinary
            . ' listtrans'
            . ' --ctxfile=' . escapeshellcmd($contextFile->getPath())
            . ' --exporter=xmldb';

        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        if ($result->getReturnVar() !== 0) {
            throw new \RuntimeException(
                'AqBanking exited with errors: ' . PHP_EOL
                . implode(PHP_EOL, $result->getErrors())
            );
        }

        $domDocument = new \DOMDocument();
        $domDocument->loadXML(implode(PHP_EOL, $result->getOutput()));

        return $domDocument;
    }
}

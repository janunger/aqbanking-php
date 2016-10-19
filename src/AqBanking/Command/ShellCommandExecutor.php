<?php

namespace AqBanking\Command;

use AqBanking\Command\ShellCommandExecutor\Result;

class ShellCommandExecutor
{
    public function execute($shellCommand)
    {
        $shellCommand = "LANG=C " . $shellCommand;
        $output = array();
        $returnVar = null;
        $tempFile = tempnam(sys_get_temp_dir(), 'aqb-');

        exec($shellCommand . ' 2>' . $tempFile, $output, $returnVar);

        $errorOutput = file($tempFile);
        $errorOutput = array_map(function ($line) {
            return rtrim($line, "\r\n");
        }, $errorOutput);
        unlink($tempFile);

        return new Result($output, $errorOutput, $returnVar);
    }
}

<?php

namespace AqBanking\Command;

use AqBanking\Command\ShellCommandExecutor\Result;

class ShellCommandExecutor
{
    public function execute($shellCommand)
    {
        $output = array();
        $returnVar = null;
        $tempFile = tempnam(sys_get_temp_dir(), 'aqb-');

        exec($shellCommand . ' 2>' . $tempFile, $output, $returnVar);

        $errors = file($tempFile);
        $errors = array_map(function ($line) {
            return rtrim($line, "\r\n");
        }, $errors);
        unlink($tempFile);

        return new Result($output, $errors, $returnVar);
    }
}

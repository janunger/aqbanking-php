<?php

namespace AqBanking\Command\ShellCommandExecutor;

class ResultAnalyzer
{
    private $expectedOutputRegexes = array(
        '/Aufträge werden ausgeführt: Started\./',
        '/Automatically accepting valid new certificate/'
    );

    /**
     * @param Result $result
     * @return bool
     */
    public function isDefectiveResult(Result $result)
    {
        if ($result->getReturnVar() !== 0) {
            return true;
        }
        if ($this->resultHasErrors($result)) {
            return true;
        }
        return false;
    }

    private function resultHasErrors(Result $result)
    {
        foreach ($result->getErrors() as $line) {
            if ($this->isErrorMessage($line)) {
                return true;
            }
        }
        return false;
    }

    private function isErrorMessage($line)
    {
        foreach ($this->expectedOutputRegexes as $regex) {
            if (preg_match($regex, $line)) {
                return false;
            }
        }
        return true;
    }
}

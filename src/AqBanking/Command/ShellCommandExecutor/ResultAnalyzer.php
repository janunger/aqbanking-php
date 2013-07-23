<?php

namespace AqBanking\Command\ShellCommandExecutor;

class ResultAnalyzer
{
    private $expectedOutputRegexes = array(
        '/Aufträge werden ausgeführt: Started\./',
        '/Automatically accepting valid new certificate/',
        '/Unexpected tag/',
        '/To debug set environment variable/',
        '/Your bank does not send an opening saldo/'
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
        if (count($result->getErrors()) == 1 && preg_match('/accepting valid new certificate/', $result->getErrors()[0])) {
            // When calling getsysid with wrong PIN, we don't get any error message.
            // The only significant aspect of the error is that the output is just one line with
            // "accepting valid new certificate"
            return true;
        }
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

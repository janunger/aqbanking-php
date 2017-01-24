<?php

namespace AqBanking\Command\ShellCommandExecutor;

class DefectiveResultException extends \Exception
{
    /**
     * @var Result
     */
    private $result;

    /**
     * @var string
     */
    private $shellCommand;

    public function __construct($message = '', $code = 0, \Exception $previous = null, Result $result = null, $shellCommand = '')
    {
        parent::__construct($message . " - Result: " . var_export($result, true) , $code, $previous);

        $this->result = $result;
        $this->shellCommand = $shellCommand;
    }

    /**
     * @return \AqBanking\Command\ShellCommandExecutor\Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getShellCommand()
    {
        return $this->shellCommand;
    }
}

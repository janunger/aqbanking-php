<?php

namespace AqBanking\Command\ShellCommandExecutor;

class Result
{
    /**
     * @var array
     */
    private $output;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var int
     */
    private $returnVar;

    /**
     * @param array $output
     * @param array $errors
     * @param int $returnVar
     */
    public function __construct(array $output, array $errors, $returnVar)
    {
        $this->output = $output;
        $this->errors = $errors;
        $this->returnVar = $returnVar;
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return int
     */
    public function getReturnVar()
    {
        return $this->returnVar;
    }
}

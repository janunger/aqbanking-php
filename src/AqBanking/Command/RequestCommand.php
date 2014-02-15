<?php

namespace AqBanking\Command;

use AqBanking\AccountInterface as Account;
use AqBanking\Command\ShellCommandExecutor\DefectiveResultException;
use AqBanking\Command\ShellCommandExecutor\ResultAnalyzer;
use AqBanking\ContextFile;
use AqBanking\PinFile\PinFileInterface as PinFile;

class RequestCommand extends AbstractCommand
{
    /**
     * @var Account
     */
    private $account;

    /**
     * @var ContextFile
     */
    private $contextFile;

    /**
     * @var PinFile
     */
    private $pinFile;

    /**
     * @param Account $account
     * @param ContextFile $contextFile
     * @param PinFile $pinFile
     */
    public function __construct(Account $account, ContextFile $contextFile, PinFile $pinFile)
    {
        $this->account = $account;
        $this->contextFile = $contextFile;
        $this->pinFile = $pinFile;
    }

    /**
     * @param \DateTime $fromDate
     * @throws ShellCommandExecutor\DefectiveResultException
     */
    public function execute(\DateTime $fromDate = null)
    {
        $shellCommand = $this->getShellCommand($fromDate);
        $result = $this->getShellCommandExecutor()->execute($shellCommand);

        $resultAnalyzer = new ResultAnalyzer();
        if ($resultAnalyzer->isDefectiveResult($result)) {
            throw new DefectiveResultException(
                'Unexpected output on polling transactions',
                0,
                null,
                $result,
                $shellCommand
            );
        }
    }

    /**
     * @param \DateTime $fromDate
     * @return string
     */
    private function getShellCommand(\DateTime $fromDate = null)
    {
        $shellCommand =
            $this->pathToAqBankingCLIBinary
            . " --noninteractive"
            . " --acceptvalidcerts"
            . " --pinfile=" . escapeshellcmd($this->pinFile->getPath())
            . " request"
            . " --bank=" . escapeshellcmd($this->account->getBankCode()->getString())
            . " --account=" . escapeshellcmd($this->account->getAccountNumber())
            . " --ctxfile=" . escapeshellcmd($this->contextFile->getPath())
            . " --transactions"
            . " --balance"
            . " --sto"     // standing orders
            . " --dated"   // dated transfers
        ;

        if (null !== $fromDate) {
            $shellCommand .= " --fromdate=" . $fromDate->format('Ymd');
        }

        return $shellCommand;
    }
}

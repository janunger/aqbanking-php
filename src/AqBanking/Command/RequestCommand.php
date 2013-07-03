<?php

namespace AqBanking\Command;

use AqBanking\Account;
use AqBanking\ContextFile;
use AqBanking\PinFile\PinFile;

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
     */
    public function execute(\DateTime $fromDate = null)
    {
        $shellCommand = $this->getShellCommand($fromDate);
        $this->getShellCommandExecutor()->execute($shellCommand);
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

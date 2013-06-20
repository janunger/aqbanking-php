<?php

require_once __DIR__ . '/../vendor/autoload.php';

$command = new \AqBanking\Command\CheckAqBankingCommand();

try {
    $command->execute();
} catch (AqBanking\Command\CheckAqBankingCommand\AqBankingNotRespondingException $e) {
    echo 'ERROR: AqBanking did not respond.' . PHP_EOL;
    exit(1);
} catch (AqBanking\Command\CheckAqBankingCommand\AqBankingVersionTooOldException $e) {
    echo 'ERROR: AqBanking responded, but seems to be too old. '
        . $e->getMessage()
        . PHP_EOL;
    exit(1);
}

echo 'AqBanking responded and is of the required version or higher. Everything seems to be fine.' . PHP_EOL;

<?php

require_once __DIR__ . '/../vendor/autoload.php';

$command = new \AqBanking\Command\CheckAqBankingCommand();

try {
    $command->execute();
} catch (AqBanking\Command\CheckAqBankingCommand\AqBankingNotRespondingException $e) {
    echo 'ERROR: AqBanking did not respond.' . PHP_EOL;
    exit(1);
} catch (AqBanking\Command\CheckAqBankingCommand\AqBankingVersionTooOldException $e) {
    echo 'ERROR: AqBanking version is too old:' . PHP_EOL
        . $e->getMessage() . PHP_EOL;
    exit(1);
}

echo 'AqBanking responded and meets the requirements.' . PHP_EOL;

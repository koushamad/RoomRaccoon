<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Process\Process;

// Load phpunit.xml
$phpunitConfig = new SimpleXMLElement(file_get_contents(__DIR__ . '/../phpunit.xml'));

// Extract environment variables
$env = [];
foreach ($phpunitConfig->php->env as $envVariable) {
    $env[(string)$envVariable['name']] = (string)$envVariable['value'];
    putenv($envVariable['name'] . "=" . $envVariable['value']);
}

// Start PHP built-in server in the background
$server = 'localhost:9090';
$publicDir = __DIR__ . '/../public';

$processS = new Process(['php', '-S', $server, '-t', $publicDir], null, $env);
$processS->start();

// Wait for the server to be ready
usleep(1000000);

// Register a shutdown function to stop the server when the tests are done
register_shutdown_function(function () use ($processS) {
    $processS->stop();
});

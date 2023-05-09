<?php

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

return [
    'database' => [
        'connection' => $_ENV['DB_CONNECTION'] ?? 'mysql',
        'mysql' => [
            'host' => $_ENV['DB_HOST'] ?? getenv('DB_HOST'),
            'port' => $_ENV['DB_PORT'] ?? getenv('DB_PORT'),
            'database' => $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE'),
            'username' => $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME'),
            'password' => $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD'),
        ],
        'sqlite' => [
            'database' => $_ENV['DB_SQLITE_PATH'] ?? getenv('DB_SQLITE_PATH'),
        ],
    ],
];

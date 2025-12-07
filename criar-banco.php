<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/bancosqlite.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$pdo->exec("CREATE TABLE  usuarios (
id INTEGER PRIMARY KEY,
email TEXT,
password TEXT
)");

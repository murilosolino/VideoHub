<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/bancosqlite.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS videos (
    id INTEGER PRIMARY KEY,
    url TEXT NOT NULL,
    title TEXT NOT NULL,
    path_documents TEXT,
    user_id_fk INTEGER NOT NULL,
    FOREIGN KEY (user_id_fk) REFERENCES usuarios(id) ON DELETE CASCADE
)");

echo "Tabelas criadas/validadas com sucesso!" . PHP_EOL;

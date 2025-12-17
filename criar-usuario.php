<?php


declare(strict_types=1);

$dbPath = __DIR__ . '/bancosqlite.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$email = "email@gmail.com";
$senha = 321;

$senha = password_hash((string) $senha, PASSWORD_ARGON2ID);

// $stmt = $pdo->exec('DROP TABLE videos');

$pdo->exec("CREATE TABLE videos(
    id INTEGER PRIMARY KEY,
    url TEXT,
    title TEXT,
    path_documents TEXT,
    user_id_fk INTEGER,
    CONSTRAINT fk_user_id FOREIGN KEY (user_id_fk) REFERENCES usuarios(id)
)");

<?php


declare(strict_types=1);

$dbPath = __DIR__ . '/bancosqlite.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$email = "email@gmail.com";
$senha = 321;

$senha = password_hash((string) $senha, PASSWORD_ARGON2ID);

$stmt = $pdo->prepare('INSERT INTO usuarios (email, password) VALUES (?,?)');
$stmt->bindValue(1, $email);
$stmt->bindValue(2, $senha);
$stmt->execute();

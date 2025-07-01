<?php
$pdo = new PDO("mysql:host=localhost;dbname=gamedle;charset=utf8", "root", "");

$hoje = date('Y-m-d');

// Verifica se já existe enigma para hoje
$check = $pdo->prepare("SELECT personagem_id FROM enigma_do_dia WHERE data = ?");
$check->execute([$hoje]);

if ($check->fetch()) {
    echo "Enigma já definido para hoje.";
    exit;
}

// Seleciona personagem aleatório
$stmt = $pdo->query("SELECT id FROM personagens ORDER BY RAND() LIMIT 1");
$personagem = $stmt->fetch();

if (!$personagem) {
    echo "Nenhum personagem encontrado.";
    exit;
}

// Salva como enigma do dia
$insert = $pdo->prepare("INSERT INTO enigma_do_dia (data, personagem_id) VALUES (?, ?)");
$insert->execute([$hoje, $personagem['id']]);

echo "Enigma do dia definido com sucesso: ID " . $personagem['id'];

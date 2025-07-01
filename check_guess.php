<?php
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=localhost;dbname=gamedle;charset=utf8", "root", "");

$guess = $_POST['guess'] ?? '';

if (!$guess) {
    echo json_encode(['error' => 'Palpite inválido']);
    exit;
}

// Pega o personagem correto (enigma do dia)
$correctStmt = $pdo->query("SELECT * FROM personagens WHERE id = 1"); // Fixado para exemplo
$correct = $correctStmt->fetch(PDO::FETCH_ASSOC);

$guessStmt = $pdo->prepare("SELECT * FROM personagens WHERE LOWER(nome) = LOWER(?)");
$guessStmt->execute([$guess]);
$guessed = $guessStmt->fetch(PDO::FETCH_ASSOC);

if (!$guessed) {
    echo json_encode(['error' => 'Personagem não encontrado']);
    exit;
}

// Compara os atributos
function comparar($valor1, $valor2) {
    return $valor1 === $valor2 ? 'correct' : (strtolower($valor1) === strtolower($valor2) ? 'partial' : 'wrong');
}

$response = [
    'guess' => [
        'name'     => $guessed['nome'],
        'campanha' => $guessed['campanha'],
        'tipo'     => $guessed['tipo'],
        'especie'  => $guessed['especie'],
        'funcao'   => $guessed['funcao'],
        'idade'    => $guessed['idade']
    ],
    'comparison' => [
        'name'     => comparar($guessed['nome'], $correct['nome']),
        'campanha' => comparar($guessed['campanha'], $correct['campanha']),
        'tipo'     => comparar($guessed['tipo'], $correct['tipo']),
        'especie'  => comparar($guessed['especie'], $correct['especie']),
        'funcao'   => comparar($guessed['funcao'], $correct['funcao']),
        'idade'    => comparar($guessed['idade'], $correct['idade']),
    ]
];

echo json_encode($response);
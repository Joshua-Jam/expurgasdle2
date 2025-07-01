<?php
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=localhost;dbname=gamedle;charset=utf8", "root", "");

$guess = $_POST['guess'] ?? '';

if (!$guess) {
    echo json_encode(['error' => 'Palpite inválido']);
    exit;
}

$hoje = date('Y-m-d');

$enigmaStmt = $pdo->prepare("
    SELECT p.* FROM enigma_do_dia e
    JOIN personagens p ON p.id = e.personagem_id
    WHERE e.data = ?
");
$enigmaStmt->execute([$hoje]);
$correct = $enigmaStmt->fetch(PDO::FETCH_ASSOC);

if (!$correct) {
    echo json_encode(['error' => 'Enigma do dia não definido.']);
    exit;
}

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

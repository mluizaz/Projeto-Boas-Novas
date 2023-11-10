<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new SQLite3('database.db');

if (!$db) {
    die("Erro na conexão com o banco de dados");
}

$query = "CREATE TABLE IF NOT EXISTS avaliacoes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR,
    email VARCHAR,
    objetivo TEXT,
    funcionalidade TEXT,
    visual TEXT
)";

$result = $db->exec($query);

if ($result !== false) {
    echo "Tabela 'avaliacoes' criada ou já existente. ";
} else {
    die("Erro na criação da tabela: " . $db->lastErrorMsg());
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') { // O restante do código relacionado ao formulário

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $objetivo = $_POST['objetivo'];
    $funcionalidade = $_POST['funcionalidade'];
    $visual = $_POST['visual'];

    $query = "INSERT INTO avaliacoes (name, email, objetivo, funcionalidade, visual) VALUES (:name, :email, :objetivo, :funcionalidade, :visual)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name, SQLITE3_TEXT);
    $stmt->bindParam(':email', $email, SQLITE3_TEXT);
    $stmt->bindParam(':objetivo', $objetivo, SQLITE3_TEXT);
    $stmt->bindParam(':funcionalidade', $funcionalidade, SQLITE3_TEXT);
    $stmt->bindParam(':visual', $visual, SQLITE3_TEXT);

    $result = $stmt->execute();

if ($result !== false) {
    echo "Dados do formulário foram armazenados com sucesso!";
} else {
    echo "Erro ao armazenar dados do formulário.";
}
        
}
}
        
$db->close();
?>
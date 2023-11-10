<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new SQLite3('database.db');

if (!$db) {
    die("Erro na conexão com o banco de dados");
}

$query = "CREATE TABLE IF NOT EXISTS contatos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR,
  email VARCHAR,
  subject VARCHAR,
  message TEXT
)";

$result = $db->exec($query);

if ($result !== false) {
    echo "Tabela 'contatos' criada ou já existente.";
} else {
    die("Erro na criação da tabela: " . $db->lastErrorMsg());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $query = "INSERT INTO contatos (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name, SQLITE3_TEXT);
    $stmt->bindParam(':email', $email, SQLITE3_TEXT);
    $stmt->bindParam(':subject', $subject, SQLITE3_TEXT);
    $stmt->bindParam(':message', $message, SQLITE3_TEXT);

    $result = $stmt->execute();

    if ($result !== false) {
        echo "Dados do formulário foram armazenados com sucesso!";
    } else {
        echo "Erro ao armazenar dados do formulário: " . $db->lastErrorMsg();
    }
}

$db->close();
?>
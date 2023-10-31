<?php
// Conexão com o banco de dados (substitua com suas próprias informações)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookdream";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$usuario = "admin"; // Nome de usuário
$senha_hash = "123Adm"; // Senha que você deseja adicionar

// Gerar um hash bcrypt da senha
$senha_hash = password_hash($senha_hash, PASSWORD_BCRYPT);

// Consulta SQL para inserir o usuário e senha criptografada
$query = "INSERT INTO usuarios (usuario, senha_hash) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $usuario, $senha_hash);
$stmt->execute();

// Fechar a conexão com o banco de dados
$conn->close();
?>

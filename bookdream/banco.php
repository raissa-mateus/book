<?php
$servername = "localhost";
$username = "root";
$password = "";

// Conexão com o servidor de banco de dados
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Conexão ao servidor falhou: " . $conn->connect_error);
}

// Criar o banco de dados "bookdream" se ele não existir
$sql = "CREATE DATABASE IF NOT EXISTS bookdream";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados 'bookdream' criado com sucesso!<br>";
} else {
    echo "Erro ao criar o banco de dados: " . $conn->error . "<br>";
}

// Conectar ao banco de dados "bookdream"
$conn = new mysqli($servername, $username, $password, "bookdream");

if ($conn->connect_error) {
    die("Conexão ao banco de dados falhou: " . $conn->connect_error);
}

// Criar tabela "usuarios" se ela não existir
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'usuarios' criada com sucesso!<br>";
} else {
    echo "Erro ao criar a tabela 'usuarios': " . $conn->error . "<br>";
}

// Excluir todos os registros da tabela "livros"
$sql = "DELETE FROM livros";
if ($conn->query($sql) === TRUE) {
    echo "Registros da tabela 'livros' excluídos com sucesso!<br>";
} else {
    echo "Erro ao excluir registros da tabela 'livros': " . $conn->error . "<br>";
}

// Criar tabela "livros" se ela não existir
$sql = "CREATE TABLE IF NOT EXISTS livros (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    editora VARCHAR(255) NOT NULL,
    genero ENUM('Romance', 'Fantasia', 'Ficção Científica', 'Ficção Policial',
        'Ação e Aventura', 'Terror', 'Infantil', 'LGBTQIA+', 'Distopia', 'Suspense',
        'Soung Adult', 'New Adult', 'Biografia', 'Conto', 'Poesia') NOT NULL,
    idioma ENUM('Português', 'Inglês', 'Espanhol', 'Outro') NOT NULL,
    classificacao ENUM('livre', '10', '12', '14', '16', '18') NOT NULL,
    qtd INT UNSIGNED NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'livros' criada com sucesso!<br>";
} else {
    echo "Erro ao criar a tabela 'livros': " . $conn->error . "<br>";
}

// Adicionar a coluna "genero" na tabela "livros"
/*$sql = "ALTER TABLE livros ADD genero TEXT";
if ($conn->query($sql) === TRUE) {
    echo "Coluna 'genero' adicionada na tabela 'livros' com sucesso!<br>";
} else {
    echo "Erro ao adicionar a coluna 'genero' na tabela 'livros': " . $conn->error . "<br>";
}*/

// Modificar o tipo de dados da coluna "qtd" na tabela "livros"
/*$sql = "ALTER TABLE livros MODIFY qtd INT UNSIGNED NOT NULL";
if ($conn->query($sql) === TRUE) {
    echo "Tipo de dados da coluna 'qtd' modificado na tabela 'livros' com sucesso!<br>";
} else {
    echo "Erro ao modificar o tipo de dados da coluna 'qtd' na tabela 'livros': " . $conn->error . "<br>";
}*/

// Fechar a conexão com o banco de dados
$conn->close();
?>

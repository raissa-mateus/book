<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookdream";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Coletar dados do formulário
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$editora = $_POST['editora'];
$genero = $_POST['genero'];
$idioma = $_POST['idioma'];
$classificacao = $_POST['classificacao'];
$qtd = $_POST['qtd'];

// Inserir livro na tabela "livros"
$sqlInserirLivros = "INSERT INTO livros (titulo, autor, editora, genero, idioma, classificacao, qtd)
VALUES ('$titulo', '$autor','$editora','$genero', '$idioma', '$classificacao', '$qtd')";
/*
$stmt = $conn->prepare($sqlInserirLivros);
$stmt->bind_param("ssssssi", $titulo, $autor, $editora, $genero, $idioma, $classificacao, $qtd);*/

if ($conn->query($sqlInserirLivros) === TRUE) {
    // Redirecionar para a página estoque.php após a inserção bem-sucedida
    header("Location: estoque.php");
    exit;
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

$conn->close();
?>

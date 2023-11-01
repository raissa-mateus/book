<?php
session_start(); // Inicia a sessão
include_once("conexao.php");


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

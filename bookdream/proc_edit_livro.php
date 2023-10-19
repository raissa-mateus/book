<?php
session_start();
include_once("conexao.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
$autor = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_STRING);
$editora = filter_input(INPUT_POST, 'editora', FILTER_SANITIZE_STRING);
$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
$classificacao = filter_input(INPUT_POST, 'classificacao', FILTER_SANITIZE_STRING);
$qtd = filter_input(INPUT_POST, 'qtd', FILTER_SANITIZE_NUMBER_INT);
$idioma = filter_input(INPUT_POST, 'idioma', FILTER_SANITIZE_STRING);

$result_livro = "UPDATE livros SET 
                  titulo='$titulo',
                  autor='$autor',
                  editora='$editora',
                  genero='$genero',
                  classificacao='$classificacao',
                  qtd=$qtd,
                  idioma='$idioma'
                WHERE id=$id";

$resultado_livro = mysqli_query($conn, $result_livro);


if(mysqli_affected_rows($conn)){
//	$_SESSION['msg'] = "<p style='color:green;'>Livro editado com sucesso</p>";
	header("Location: estoque.php");
}else{
	$_SESSION['msg'] = "<p style='color:red;'>Não houveram alterações</p>";
	header("Location: editar_livro.php?id=$id");
}

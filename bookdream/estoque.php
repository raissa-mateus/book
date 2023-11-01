<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookdream";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Retrieve book data from the database
$sql = "SELECT id, titulo, autor, editora, genero, classificacao, idioma, qtd FROM livros";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque de Livros</title>
    <style>
    body {
      background-color: #fff;
      font-family: Arial, sans-serif;
    }

        .container {
          max-width: 90%;
          margin: 0 auto;
          margin-top: 30px;
          padding: 20px;
          background-color: #f2f2f2;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        #menu1, #menu2 {
          display: flex;
        }
        
        #menu1 a, #menu2 a {
          font-family: Arial, sans-serif;
          text-decoration: none;
          color: white;
          padding: 10px;
          margin-right: 10px;
          background-color: #BEA4F1;
          border-radius: 5px;
          font-size: 20px;
        }
        
        #menu1 a:hover {
          background-color: #AFCCF4;
        }

         #menu2 a:hover {
          background-color: #AFCCF4;
        }

        #menu2 {
          margin-left: 830px;
        }
        #header {
        margin-left: 0;
        background-color: #AFCCF4;
        padding: 0px;
        display: flex;
        align-items: center;
        }
        .logo {
          height: 80px;
          width: 150px;
        }
        h1 {
            text-align: center;
        }

        h2{
           font-size: 15px;
           border-radius: 10px;
           color:#BEA4F1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #ddd;
            font-weight: bold;
            
        }

        #qtd{
            text-align: center;
        }
        td a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #FFAFE0;
            color: white;
            border-radius: 5px;
        }
        td a:hover {
            background-color: #0056b3;
        }

        /* Estilos para os botões */
        .btn-container {
            display: flex;
            justify-content: flex-end; /* Alinhar à direita */
            margin-top: 20px; /* Espaçamento entre a linha superior */
        }

        .btn-container button {
            margin-left: 10px; /* Espaçamento entre os botões */
            padding: 10px 20px;
            background-color: #FFAFE0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-container button:hover {
            background-color: #AFCCF4;
        }

        /* Estilos para a caixa de pesquisa e o botão */
        .search-form {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 250px;
            outline: none;
        }

        .search-form select {
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-left: 10px;
            outline: none;
        }

        .search-button {
            padding: 10px 20px;
            background-color: #FFAFE0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
        }

        .search-button:hover {
            background-color: #AFCCF4;
        }
 
    </style>
</head>
<div id="header">
        <img class="logo" src="imagens/logo-book-dream2.png">
        <div id="menu1">
            <a href="cadlivro.php">Cadastro</a>
            <a href="estoque.php">Estoque</a>
            <a href="carrinho.php">Venda</a>
        </div>
        <div id="menu2">
            <a href="logout.php">Sair</a>
        </div>
    </div>
<body>

<div class="container">
<h1>Estoque de Livros</h1>
<h2>Consulta de Livros</h2>

<form method="get" action="estoque.php" class="search-form">
    <input type="text" name="search" placeholder="Pesquisar...">
    <select name="filter">
        <option value="titulo">Título</option>
        <option value="autor">Autor</option>
        <option value="editora">Editora</option>
        <option value="genero">Gênero</option>
        <option value="classificacao">Classificação</option>
    </select>
    <button type="submit" class="search-button">Pesquisar</button>
</form>
<table>
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Editora</th>
        <th>Gênero</th>
        <th>Classificação</th>
        <th>Idioma</th>
        <th>Quantidade</th>
        <th>Ações</th>
    </tr>



    <?php
    $searchTerm = $_GET['search'] ?? '';
    $filter = $_GET['filter'] ?? 'titulo';
    
    $sql = "SELECT id, titulo, autor, editora, genero, classificacao, idioma, qtd FROM livros";
    
    if (!empty($searchTerm)) {
        $filter = mysqli_real_escape_string($conn, $filter);
        $searchTerm = mysqli_real_escape_string($conn, $searchTerm);
        $sql .= " WHERE $filter LIKE '%$searchTerm%'";
    }
    $sql .= " ORDER BY titulo"; // Adicione esta linha para ordenar por título.
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["titulo"] . "</td>";
            echo "<td>" . $row["autor"] . "</td>";
            echo "<td>" . $row["editora"] . "</td>";
            echo "<td>" . $row["genero"] . "</td>";
            echo "<td>" . $row["classificacao"] . "</td>";
            echo "<td>" . $row["idioma"] . "</td>";
            echo "<td>" . $row["qtd"] . "</td>";
            echo "<td>";
            echo "<a href='editar_livro.php?id=" . $row["id"] . "'>editar</a> ";
          //  echo "<a href='carrinho.php?action=add&id=" . $row["id"] . "'>Adicionar ao Carrinho</a></td>";

            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Nenhum livro cadastrado</td></tr>";
    }
/* video editar dados no formulario: https://www.youtube.com/watch?v=sNqH8Nql1iA */ 
    ?>

</table>
</div>
</body>
</html>

<?php
$conn->close();
?>

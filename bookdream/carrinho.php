<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookdream";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $livro_id = $_GET['id'];
    if (!isset($_SESSION['carrinho'][$livro_id])) {
        $_SESSION['carrinho'][$livro_id] = 1;
    } else {
        $_SESSION['carrinho'][$livro_id]++;
    }
}

if (isset($_POST['atualizar'])) {
    foreach ($_POST['qtd'] as $livro_id => $quantidade) {
        $quantidade = intval($quantidade); // Converta para inteiro
        if ($quantidade >= 0) {
            $_SESSION['carrinho'][$livro_id] = $quantidade;
        } else {
            $_SESSION['carrinho'][$livro_id] = 0; // Define como 0 se for negativo
        }
    }
}

if (isset($_POST['finalizar_venda'])) {
    foreach ($_SESSION['carrinho'] as $livro_id => $qtd) {
        $qtd = intval($qtd); // Converta para inteiro
        if ($qtd >= 0) {
            // Atualize o estoque no banco de dados
            $sql = "UPDATE livros SET qtd = qtd - $qtd WHERE id = $livro_id";
            $conn->query($sql);
        }
    }

    // Limpe o carrinho e redirecione
    $_SESSION['carrinho'] = [];
    header("Location: estoque.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <style>
        body {
      margin-left: 8px;
      margin-top: 8px;
      margin-right:8px;
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
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
        td a:hover {
            background-color: #0056b3;
        }
    
    </style>
</head>
<body>
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
    <div class="container">
        <h1>Carrinho de Compras</h1>

        <form method="get" action="estoque.php">
    <input type="text" name="search" placeholder="Digite sua pesquisa">
    <select name="filter">
        <option value="titulo">Título</option>
        <option value="autor">Autor</option>
        <option value="editora">Editora</option>
        <option value="genero">Gênero</option>
        <option value="classificacao">Classificação</option>
    </select>
    <input type="submit" value="Pesquisar">
</form>
        <form method="post" action="carrinho.php">
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
                
                $result = $conn->query($sql);
            
                // ...
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
                        echo "<a href='carrinho.php?action=add&id=" . $row["id"] . "'>Adicionar ao Carrinho</a></td>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhum livro selecionado</td></tr>";
                }
                // ...


                
            
                foreach ($_SESSION['carrinho'] as $livro_id => $qtd) {
                    $sql = "SELECT titulo FROM livros WHERE id = $livro_id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<tr>";
                        echo "<td>" . $row["titulo"] . "</td>";
                        echo "<td><input type='number' name='qtd[$livro_id]' value='$qtd'></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
            <button type="submit" name="finalizar_venda" value="1">Finalizar Venda</button>
        </form>
    </div>
</body>
</html>

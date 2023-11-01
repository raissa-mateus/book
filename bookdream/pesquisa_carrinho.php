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

// Inicialize o carrinho apenas se ele não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_GET['action']) && $_GET['action'] === "add" && isset($_GET['id'])) {
    $livro_id = $_GET['id'];
    $sql = "SELECT titulo, qtd FROM livros WHERE id = $livro_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $estoque_disponivel = $row['qtd'];

        // Verifica se o livro pode ser adicionado ao carrinho
        if (!isset($_SESSION['carrinho'][$livro_id]) || $_SESSION['carrinho'][$livro_id] < $estoque_disponivel) {
            if (!isset($_SESSION['carrinho'][$livro_id])) {
                $_SESSION['carrinho'][$livro_id] = 1;
            } else {
                $_SESSION['carrinho'][$livro_id]++;
            }
        }
    }
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
            margin-left: 800px;
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

        h2 {
            font-size: 15px;
            border-radius: 10px;
            color: #BEA4F1;
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

        #qtd {
            text-align: center;
        }

        td a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #afccf4;
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
            margin-top: 20px; /* Espaçamento between a linha superior */
        }

        .btn-container a {
            margin-left: 10px; /* Espaçamento entre os botões */
            padding: 10px 20px;
            background-color: #FFAFE0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-container a:hover {
            background-color: #AFCCF4;
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
    <div class="btn-container">
            <a href="carrinho.php" class="btn-voltar-carrinho">Voltar ao Carrinho</a> <!-- Botão "Voltar ao Carrinho" -->
        </div>
    <form method="post" action="carrinho.php">
        <table>
            <tr>
                <th>Título</th>
                <th>Quantidade</th>
                <th class="status">Status</th>
            </tr>
            <?php
            // Verificar se há uma pesquisa em andamento
            if (isset($_GET['search']) && isset($_GET['filter'])) {
                $search = $_GET['search'];
                $filter = $_GET['filter'];
                $sql = "SELECT id, titulo, qtd FROM livros WHERE $filter LIKE '%$search%'";
            } else {
                // Consulta padrão para exibir o carrinho
                $sql = "SELECT id, titulo, qtd FROM livros";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $livro_id = $row['id'];
                    $qtd_no_carrinho = isset($_SESSION['carrinho'][$livro_id]) ? $_SESSION['carrinho'][$livro_id] : 0;
                    echo "<tr>";
                    echo "<td>" . $row["titulo"] . "</td>";

                    // Exibe o estoque disponível subtraindo a quantidade no carrinho
                    $estoque_disponivel = $row["qtd"] - $qtd_no_carrinho;
                    echo "<td>" . $estoque_disponivel . "</td>";

                    // Verificar se há uma mensagem de erro para este livro
                    $mensagem_de_erro_para_livro = "";
                    if (isset($mensagem_de_erro) && $_GET['id'] == $livro_id) {
                        $mensagem_de_erro_para_livro = "Limite selecionado";
                    }
                    echo "<td>" . $mensagem_de_erro_para_livro . "</td";

                    // Adicionar botão "Adicionar ao Carrinho" se houver estoque disponível
                    if ($estoque_disponivel > 0) {
                        echo "<td><a href='pesquisa_carrinho.php?action=add&id=" . $row["id"] . "'>Adicionar ao Carrinho</a></td>";

                    } else {
                        echo "<td>Sem estoque</td>";
                    }

                    echo "</tr>";
                }

            }
            ?>
        </table>
        
    </form>
</div>
</body>
</html>
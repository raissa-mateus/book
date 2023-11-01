<?php
session_start(); // Inicia a sessão
include_once("conexao.php");

// Inicialize o carrinho apenas se ele não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Tratamento de adição ou remoção de itens do carrinho
if (isset($_POST['add_to_cart']) && isset($_POST['livro_id'])) {
    $livro_id = $_POST['livro_id'];

    // Verifica se o livro existe
    $sql = "SELECT qtd, titulo FROM livros WHERE id = $livro_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $estoque_disponivel = $row['qtd'];

        // Verifica se a quantidade a ser adicionada é menor ou igual à quantidade disponível
        if (!isset($_SESSION['carrinho'][$livro_id]) || $_SESSION['carrinho'][$livro_id] < $estoque_disponivel) {
            if (!isset($_SESSION['carrinho'][$livro_id])) {
                $_SESSION['carrinho'][$livro_id] = 1;
            } else {
                $_SESSION['carrinho'][$livro_id]++;
            }
        } else {
            // Armazenar a mensagem de erro na sessão, associada ao livro
            $_SESSION['mensagens_de_erro'][$livro_id] = "Limite selecionado para " . $row['titulo'];
        }
        
    } else {
        $mensagem_de_erro = "Livro não encontrado."; // Configurar mensagem de erro se o livro não for encontrado
    }
}

//testeeee remover
if (isset($_POST['remove_from_cart']) && isset($_POST['livro_id'])) {
    $livro_id = $_POST['livro_id'];

    // Verificar se o livro está no carrinho
    if (isset($_SESSION['carrinho'][$livro_id]) && $_SESSION['carrinho'][$livro_id] > 0) {
        $_SESSION['carrinho'][$livro_id]--; // Remover uma unidade
    }
}

//fim do teste remover

if (isset($_POST['finalizar_venda'])) {
    // Verificar se o carrinho está vazio
    if (empty($_SESSION['carrinho'])) {
        $mensagem_de_venda = "O carrinho está vazio. Nenhuma venda foi realizada.";
    } else {
        foreach ($_SESSION['carrinho'] as $livro_id => $qtd) {
            $qtd = intval($qtd); // Converte para inteiro
            if ($qtd >= 0) {
                // Atualize o estoque no banco de dados
                $sql = "UPDATE livros SET qtd = qtd - $qtd WHERE id = $livro_id";
                $conn->query($sql);
            }
        }

        // Limpe o carrinho
        $_SESSION['carrinho'] = [];
        $mensagem_de_venda = "Venda finalizada com sucesso!";
    }
}

if (isset($_POST['cancelar_venda'])) {
    // Limpe o carrinho
    $_SESSION['carrinho'] = [];
    $mensagem_de_venda = "Venda cancelada. O carrinho foi esvaziado.";
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

        td.status {
            width: 200px; /* Largura fixa para as colunas de Título e Quantidade */
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

        /* Estilos para o botão Adicionar ao Carrinho */
        .small-button {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #afccf4;
            color: white;
            border-radius: 5px;
            white-space: nowrap;
            border: none;
        }

        .small-button:hover {
            background-color: #FFAFE0;
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
    <form method="post" action="carrinho.php">
        <table>
            <tr>
                <th>Título</th>
                <th>Quantidade</th>
                <th class="status">Status</th> <!-- Coluna para o status -->
            </tr>
            <?php
        foreach ($_SESSION['carrinho'] as $livro_id => $qtd) {
            $sql = "SELECT titulo, qtd FROM livros WHERE id = $livro_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<tr>";
                echo "<td>" . $row["titulo"] . "</td>";
                echo "<td>" . $qtd . "</td>";

                // Adicionar botões "Adicionar ao Carrinho" e "Remover do Carrinho"
                echo "<td>";
                echo "<form method='post' action='carrinho.php'>";
                echo "<input type='hidden' name='livro_id' value='" . $livro_id . "'>";
                echo "<div style='display: flex; align-items: center;'>";
                echo "<input type='submit' name='remove_from_cart' value='Remover do Carrinho' class='small-button' style='margin-right: 5px;'>";
                echo "<input type='submit' name='add_to_cart' value='Adicionar ao Carrinho' class='small-button'>";
                echo "</div>";
                echo "</form>";
                echo "</td>";

                // Verificar se há uma mensagem de erro para este livro
                $mensagem_de_erro_para_livro = isset($_SESSION['mensagens_de_erro'][$livro_id]) ? $_SESSION['mensagens_de_erro'][$livro_id] : "";

                echo "<td>" . $mensagem_de_erro_para_livro . "</td>";

                echo "</tr>";
            }
        }
        ?>
        </table>
        <div class="btn-container">
            <button type="submit" name="cancelar_venda" value="1">Cancelar Venda</button>
            <button type="submit" name="finalizar_venda" value="1">Finalizar Venda</button>
        </div>
    </form>
</div>

<div class="container">
    <h2>Estoque de Livros</h2>
    <form method="get" action="pesquisa_carrinho.php" class="search-form">
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
        $sql = "SELECT id, titulo, autor, editora, genero, classificacao, idioma,  qtd FROM livros ORDER BY titulo";
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

                if ($row["qtd"] > 0) {
                    // Adicione o botão "Adicionar ao Carrinho" para cada livro com estoque disponível
                    echo "<form method='post' action='carrinho.php'>";
                    echo "<input type='hidden' name='livro_id' value='" . $row["id"] . "'>";
                    echo "<input type='submit' name='add_to_cart' value='Adicionar ao Carrinho' class='small-button'>";
                    echo "</form>";
                } else {
                    echo "Sem estoque";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Nenhum livro disponível</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
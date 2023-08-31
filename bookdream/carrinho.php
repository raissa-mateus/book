<!DOCTYPE html>
<html>
<head>
    <title>Carrinho de Compras</title>
    <style>
         #header {
          margin-left: 0;
          background-color: #AFCCF4;
          padding: 0px;
          display: flex;
          align-items: center;
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
          margin-left: auto;
        }

        .logo {
          height: 80px;
          width: 150px;
        }

    </style>
</head>
<div id="header">
        <img class="logo" src="imagens/logo-book-dream2.png">
        <div id="menu1">
            <a href="cadlivro.php">Cadastro</a>
            <a href="estoque.php">Estoque</a>
            <a href="carrinho.php">Carrinho</a>

        </div>
        <div id="menu2">
            <a href="">Sair</a>
            <a href="login.php">login</a>
        </div>
    </div>
    <body>
    <h1>Produtos Disponíveis</h1>
    <ul>
        <li>Item 1</li>
        <li>Item 2</li>
        <li>Item 3</li>
    </ul>

    <h2>Adicionar ao Carrinho</h2>
    <form method="post" action="">
        <select name="produto">
            <option value="Item 1">Item 1</option>
            <option value="Item 2">Item 2</option>
            <option value="Item 3">Item 3</option>
        </select>
        <input type="submit" name="adicionar" value="Adicionar ao Carrinho">
    </form>
    <h2>Seu Carrinho de Compras</h2>
    <a href="?acao=exibir">Exibir Carrinho</a>
               
</body>
</html>


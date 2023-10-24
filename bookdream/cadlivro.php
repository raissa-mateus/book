<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
} 

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Book Dream</title>
  <style>
        /* Estilos para o cabeçalho ... */
        /*cores logo
        
        #ADE4EB; verde agua
        #AFCCF4; azul escuro claro
        #FFAFE0; rosa
        #BEA4F1; lilás
        */
        /* Estilos para o formulário ... */

          body {
    
      background-color: #fff;
    }
    

        #header {
          margin-left: 0;
          background-color: #AFCCF4;
          padding: 0px;
          display: flex;
          align-items: center;
        }
        
        /*#logo {
          color: white;
          font-family: Arial, Helvetica, sans-serif;
          font-size: 40px;
          font-weight: bold;
          margin-right: 50px;
        }*/

        .logo {
          height: 80px;
          width: 150px;
        }

        h2 {
          margin-bottom: -10px;
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

        .h3inferiores{
            text-align: center;
            font-size: 25px;
            font-family: Arial, sans-serif;
            color: white;
            margin-top: 50px;
        }

        /* fundo formulario*/
        .container {
          max-width: 90%;
          margin: 0 auto;
          margin-top: 30px;
          padding: 20px;
          background-color: #f2f2f2;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    
        .container h2 {
          text-align: center;
          font-size: 30px;
          font-family: Arial, sans-serif;
          color: black;
        }

        .container h3 {
            text-align: center;
            font-size: 20px;
            font-family: Arial, sans-serif;
            color: black;
        }
    
        .container form {
          margin-top: 20px;
          color: white;
        }
    
        .container form label,
        .container form input {
          display: block; /* Para que os campos fiquem em uma linha separada */
          width: 100%; /* Para ocupar toda a largura da linha */
        }
    
        .container form label {
          text-align: left;
          margin-bottom: 0px;
          font-size: 115%;
          font-family: Arial, sans-serif;
          color: black;

        }
    
        .container form input[type="text"],
        .container form select,
        .container form input[type="radio"],
        .container form input[type="number"] {
          padding: 10px;
          border: 1px solid ;
          border-radius: 5px;
          margin-bottom: -10px;
          width: 100%;
          box-sizing: border-box;
          font-size: 130%;
        }
    
        .botoes {
          text-align: right; /* Alinhar os botões à direita */
        }

        .botoes a, .botoes button {
          font-family: Arial, sans-serif;
          text-decoration: none;
          color: #e1e1e1;
          padding: 10px 20px;
          margin-top: 10px;
          margin-right: 10px;
          background-color: #BEA4F1;
          border-radius: 5px;
          font-size: 20px;
        }

        .botoes a:hover, .botoes button:hover {
          background-color: rgb(177, 177, 177);
        }

        /* Estilos para a divisão de colunas ... */
              .div1 {
          width: 40%;
          text-align: center;
          display: inline-block;
          padding: 10px;
          box-sizing: border-box;
        }

        .div2 {
          width: 17%;
          text-align: center;
          display: inline-block;
          padding: 10px;
          box-sizing: border-box;
        }

        .div3 {
          width: 21%;
          text-align: center;
          display: inline-block;
          padding: 10px;
          box-sizing: border-box;
        }

        .div4 {
            width: 20%;
            text-align: center;
            display: inline-block;
            padding: 10px;
            box-sizing: border-box;
          }

          .div5 {
            width: 20px%;
            text-align: center;
            display: inline-block;
            padding: 10px;
            box-sizing: border-box;
          }

          .div6 {
            width: 33%;
            text-align: center;
            display: inline-block;
            padding: 10px;
            box-sizing: border-box;
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
   <!-- Cabeçalho da página ... -->

  <!-- Conteúdo principal -->
  <div class="container">

    <h2>Cadastro de Livros</h2>
    <!--<h3 class="h3inferiores">CADASTRO DE LIVRO</h3> -->

    <form  method="POST" action="processalivros.php">

      <div class="div1">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" placeholder="" required>
      </div>

      <div class="div2">
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" placeholder="" required>
      </div>

      <div class="div2">
        <label for="editora">Editora:</label>
        <input type="text" id="editora" name="editora" placeholder="" required>
      </div>

      <div class="div3">
          <label for="genero">Gênero </label>
          <select name="genero" id="genero">
            <option></option>
            <option value="Romance">Romance</option>
            <option value="Fantasia">Fantasia</option>
            <option value="Ficção Cientfica">Ficção Científica</option>
            <option value="Ficção Policial">Ficção Policial</option>
            <option value="Ação e Aventura">Ação e Aventura</option>
            <option value="Terror">Terror</option>
            <option value="Infantil">Infantil</option>
            <option value="LGBTQIA+">LGBTQIA+</option>
            <option value="Distopia">Distopia</option>
            <option value="Suspense">Suspense</option>
            <option value="Young Adult">Young Adult</option>
            <option value="New Adult">New Adult</option>
            <option value="Biografia">Biografia</option>
            <option value="Conto">Conto</option>
            <option value="Poesia">Poesia</option>
          </select>
        </div> <!-- FIM GENERO-->
            
            <div  class="div4">
                <label for="classificacao">Classificação</label>
                <select name="classificacao" id="classificacao">Classificação
                   <option value=""></option>
                    <option value="livre">Livre</option>
                    <option value="10">10 anos</option>
                    <option value="12">12 anos</option>
                    <option value="14">14 anos</option>
                    <option value="16">16 anos</option>
                    <option value="18">18 anos</option>
                </select>
            </div>

            <div  class="div5">
              <label for="qtd">Quantidade</label>
              <input type="number" id="qtd" name="qtd" min="1" required>
            </div>

            <div  class="div6">
                <label for="idioma">Idioma </label>
                <select name="idioma" id="idioma">Idioma
                <option value=""></option>
                <option value="Português">Português</option>
                    <option value="Inglês">Inglês</option>
                    <option value="Espanhol">Espanhol</option>
                    <option value="Outro">Outro</option>
                </select>
                </div>
            </br>


      <div class="botoes">
        <a id="voltar" href="">Cancelar</a>
        <button id="cadastrar" type="submit">Cadastrar</button>
      </div>
    </form>
  </div>
</body>
</html>

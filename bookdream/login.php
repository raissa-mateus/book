<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Book Dream</title>
    <style>

body {
 background-color: white ;
}

#login {
  float: right;
  margin-right: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  /*font-family: ;*/
  
}

.card {
  background-color: #FFAFE0;
  padding: 40px;
  border-radius: 15px;
  width: 350px;
}

.cabecalho-card {
  padding-bottom: 50px;
  opacity: 0.8;
  color: #fff;
  text-align: center;
}

.cabecalho-card::after {
  content: "";
  width: 110px;
  height: 1px;
  background-color: #fff;
  display: block;
  margin-top: -17px;
  margin-left: 120px;
}

.conteudo-card label {
  color: #fff;
  font-size: 16px;
  opacity: 0.8;
}

.conteudo-card-area {
  display: flex;
  flex-direction: column;
  padding: 10px 0;
}

.conteudo-card-area input {
  margin-top: 10px;
  padding: 0 5px;
  background-color: transparent;
  border: none;
  border-bottom: 1px solid #e1e1e1;
  outline: none;
  color: #fff;
}

.card-rodape {
  display: flex;
  flex-direction: column;
}

.card-rodape .submit{
  width: 100%;
  height: 40px;
  background-color: #BEA4F1;
  border:none;
  color:#e1e1e1;
  margin: 10px 0;
} 

.card-rodape a {
  text-align: center;
  font-size: 12px;
  opacity: 0.8;
  color: #fff;
  text-decoration: none;
}

.logo {
  position: relative;
  top: 80px;
  left: 180px;
}

.card-rodape #botao-login {
  color: rgb(187, 0, 0);
}

.card-rodape #botao-cadastro {
  color: rgb(243, 163, 232);
}

/* estilização botao enviar*/
#enviar {
  background-color: #BEA4F1;
  height: 30px;
  width: 100%;
  font-weight: bold;
  border: none;
  color: #fff;
}

    </style>
</head>
<body>

   <img class="logo" src="imagens/logo-book-dream.png" width="30%">
                <div id="login">
            <form method="POST" action="processaLogin.php" class="card">
		<!--<fieldset>-->
	    <div class="cabecalho-card">
            <h2>Login</h2>

        </div> <!--class="cabecalho-card"-->

    <div class="conteudo-card">
        <div class="conteudo-card-area">
   			<label for="usuario">Usuário </label> 
        <input type="text"  id="usuario"  name="usuario" required>
        </div>
        <div class="conteudo-card-area">
            <label for="senha">Senha </label> 
        <input type="password"  id="senha"  name="senha" required>
        </div>
    </div> <!--class="conteudo-card"-->

    <div class="card-rodape">
    <div class="botoes">
        <button type="submit" id="enviar">Enviar</button>
      </div>
        <!--<input type="submit" class="enviar" onclick="window.location.href = 'index.html' " value="Enviar" /> -->
        

     <!--   <p class="link">
            Ainda não tem conta?
            <a href="cadastro.html"> Cadastre-se</a>
        </p>  -->
    
    </div> <!--class="card-rodape"-->
    </form>
    </div> <!--id="login"-->
     <!-- Exibir mensagem de erro, se houver -->
     <?php
    //if (isset($_SESSION['login_error'])) {
   //     echo '<p>' . $_SESSION['login_error'] . '</p>';
   //     unset($_SESSION['login_error']);
   // }
    ?>

</body>
</html>


<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["usuario"]) && isset($_POST["senha"])) {
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
    
    // Conexão com o banco de dados (substitua com suas próprias informações)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookdream";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Consulta SQL para verificar as credenciais
    //$query = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
    //$result = mysqli_query($conn, $query);
    
     // Consulta SQL para verificar as credenciais (usando placeholders para evitar SQL injection)
     $query = "SELECT * FROM usuarios WHERE usuario=? AND senha=?";
     $stmt = $conn->prepare($query);
     $stmt->bind_param("ss", $usuario, $senha);
     $stmt->execute();
     $result = $stmt->get_result();
 

    if (mysqli_num_rows($result) == 1) {
        // Inicia a sessão
    session_start();
    
    // Define uma variável de sessão para indicar o login
    $_SESSION['logged_in'] = true;
    $_SESSION['nomeUsuario'] = $usuario;
    $_SESSION['senhaUsuario'] = $senha;
        // Login bem-sucedido
        header("Location: estoque.php");
    exit;
    } else {
        // Login falhou
        echo "Nome de usuário ou senha incorretos.";
    }
    
    mysqli_close($conn);
}
}
    ?>
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

        // Consulta SQL para obter a senha criptografada do banco de dados
        $query = "SELECT senha_hash FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $senha_hash = $row["senha_hash"];

            // Verificar se a senha fornecida corresponde à senha criptografada no banco de dados
            if (password_verify($senha, $senha_hash)) {
                // Senha correta, realizar ações de login
                $_SESSION['logged_in'] = true;
                $_SESSION['nomeUsuario'] = $usuario;
                header("Location: estoque.php");
                exit;
            }
        }
        
        // Senha incorreta ou nome de usuário incorreto, recarregar a página de login
        echo '<meta http-equiv="refresh" content="1;url=index.php">';
    }
}
?>

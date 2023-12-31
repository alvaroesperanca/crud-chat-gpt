<?php
// Conexão com o banco de dados (substitua pelos seus dados)
include_once "conexao.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta o banco de dados para verificar o usuário
    $sql = "SELECT * FROM usuarios WHERE nome = '$username' AND senha = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuário autenticado com sucesso
        $row = $result->fetch_assoc();
        if ($row["role"] == "admin") {
            header("Location: cadastro.php");
            exit();
        } else {
            // Usuário sem permissão de administrador
            echo "<script>alert('Você não tem permissão para acessar esta página.');</script>";
        }
    } else {
        // Usuário ou senha incorretos
        echo "<script>alert('Usuário ou senha incorretos. Tente novamente.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header btn-primary">
                    <h3 class="text-center">Login</h3>
                </div>
                <div class="card-body">
                    <!-- Formulário de login aqui -->
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label for="username">Usuário:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>

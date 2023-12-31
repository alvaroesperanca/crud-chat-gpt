<?php
// Conexão com o banco de dados (substitua pelos seus dados)
include_once "conexao.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta os dados na tabela "usuarios"
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Lista de Usuários</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Senha</th>
                            <th>Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Exibe os dados da consulta
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["nome"] . "</td>";
                                echo "<td>" . $row["senha"] . "</td>";
                                echo "<td>" . $row["role"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Nenhum usuário encontrado.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulário para cadastrar novos dados -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="text-center">Cadastrar Novo Usuário</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="processa_cadastro.php">
                        <div class="form-group">
                            <label for="new_nome">Nome:</label>
                            <input type="text" class="form-control" id="new_nome" name="new_nome" required>
                        </div>
                        <div class="form-group">
                            <label for="new_senha">Senha:</label>
                            <input type="password" class="form-control" id="new_senha" name="new_senha" required>
                        </div>
                        <div class="form-group">
                            <label for="new_role">Role:</label>
                            <select class="form-control" id="new_role" name="new_role" required>
                                <option value="admin">Admin</option>
                                <option value="user">Usuário</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                    </form>
                </div>
            </div>

            <div class="container mt-3">
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>

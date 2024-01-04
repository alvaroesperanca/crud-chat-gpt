<?php
// Conexão com o banco de dados (substitua pelos seus dados)
include_once "conexao.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Lógica para exclusão de usuário
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];

    // Verifica se o ID é numérico antes de prosseguir
    if (is_numeric($delete_id)) {
        // Não permite excluir o usuário com ID 1 (admin)
        if ($delete_id == 1) {
            echo "<script>alert('Não é possível excluir o usuário admin.'); window.location.href = 'cadastro.php';</script>";
        } else {
            // Consulta para obter informações do usuário antes da exclusão
            $select_sql = "SELECT * FROM usuarios WHERE id = $delete_id";
            $result = $conn->query($select_sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nome_usuario = $row["nome"];

                // Exibe a mensagem de confirmação
                echo "<script>
                        var confirmacao = confirm('Tem certeza que deseja excluir o usuário \"$nome_usuario\"?');

                        if (confirmacao) {
                            window.location.href = 'cadastro.php?confirm_delete_id=$delete_id';
                        } else {
                            window.location.href = 'cadastro.php';
                        }
                    </script>";
            }
        }
    }
}

// Lógica para confirmar e realizar a exclusão
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["confirm_delete_id"])) {
    $confirm_delete_id = $_GET["confirm_delete_id"];

    // Verifica se o ID é numérico antes de prosseguir
    if (is_numeric($confirm_delete_id)) {
        // Não permite excluir o usuário com ID 1 (admin)
        if ($confirm_delete_id == 1) {
            echo "<script>alert('Não é possível excluir o usuário admin.'); window.location.href = 'cadastro.php';</script>";
        } else {
            // Atualiza o status do usuário para "inativo"
            $update_status_sql = "UPDATE usuarios SET estado='inativo' WHERE id = $confirm_delete_id";

            if ($conn->query($update_status_sql) === TRUE) {
                echo "<script>alert('Usuário marcado como inativo com sucesso.'); window.location.href = 'cadastro.php';</script>";
            } else {
                echo "<script>alert('Erro ao marcar usuário como inativo.'); window.location.href = 'cadastro.php';</script>";
            }
        }
    }
}

// Lógica para processar o formulário de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $new_nome = $_POST["new_nome"];
    $new_senha = $_POST["new_senha"];
    $new_role = $_POST["new_role"];

    $insert_sql = "INSERT INTO usuarios (nome, senha, role) VALUES ('$new_nome', '$new_senha', '$new_role')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Usuário cadastrado com sucesso.'); window.location.href = 'cadastro.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuário.'); window.location.href = 'cadastro.php';</script>";
    }
}

// Consulta os dados na tabela "usuarios"
$sql = "SELECT * FROM usuarios";
$sql2 = "SELECT * FROM usuarios where estado = 'ativo'";
$result = $conn->query($sql);
$resultado = $conn->query($sql2);


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

<!-- ... (código anterior) ... -->

<div class="card-body">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Senha</th>
            <th>Role</th>
            <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Exibe os dados da consulta
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["senha"] . "</td>";
                echo "<td>" . $row["role"] . "</td>";

                // Adiciona os botões Editar e Excluir somente se o ID não for 1
                if ($row["id"] != 1) {
                    echo "<td>
                            <a href='editar.php?edit_id=" . $row["id"] . "' class='btn btn-success'>Editar</a>
                            <a href='cadastro.php?delete_id=" . $row["id"] . "' class='btn btn-danger'>Excluir</a>
                          </td>";
                } else {
                    echo "<td></td>"; // Para o usuário com ID 1, não exibe botões
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum usuário encontrado.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- ... (código anterior) ... -->



        </div>

        <!-- Botão de Logout -->
        <div class="container mt-3">
          <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>

        <!-- Formulário para cadastrar novos dados -->
        <div class="card mt-3">
          <div class="card-header">
            <h3 class="text-center">Cadastrar Novo Usuário</h3>
          </div>
          <div class="card-body">
            <form method="post" action="cadastro.php">
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
                  <option value="usuario">Usuário</option>
                </select>
              </div>
              <button type="submit" name="submit" class="btn btn-primary">Cadastrar</button>
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
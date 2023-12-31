<?php
// Conexão com o banco de dados (substitua pelos seus dados)
include_once "conexao.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Lógica para atualização de usuário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $update_id = $_POST["update_id"];
    $update_nome = $_POST["update_nome"];
    $update_senha = $_POST["update_senha"];
    $update_role = $_POST["update_role"];

    // Não permite editar o usuário com ID 1 (admin)
    if ($update_id == 1) {
        echo "<script>alert('Não é possível editar o usuário admin.'); window.location.href = 'cadastro.php';</script>";
    } else {
        $update_sql = "UPDATE usuarios SET nome='$update_nome', senha='$update_senha', role='$update_role' WHERE id=$update_id";

        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Usuário atualizado com sucesso.'); window.location.href = 'cadastro.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar usuário.'); window.location.href = 'cadastro.php';</script>";
        }
    }
}

// Verifica se foi passado um ID válido pela URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["edit_id"])) {
    $edit_id = $_GET["edit_id"];

    // Verifica se o ID é numérico antes de prosseguir
    if (is_numeric($edit_id)) {
        // Consulta os dados do usuário
        $select_sql = "SELECT * FROM usuarios WHERE id = $edit_id";
        $result = $conn->query($select_sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $edit_nome = $row["nome"];
            $edit_senha = $row["senha"];
            $edit_role = $row["role"];
        } else {
            echo "<script>alert('Usuário não encontrado.'); window.location.href = 'cadastro.php';</script>";
        }
    }
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Editar Usuário</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
</head>

<body>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Editar Usuário</h3>
          </div>
          <div class="card-body">
            <form method="post" action="editar.php">
              <input type="hidden" name="update_id" value="<?php echo $edit_id; ?>">
              <div class="form-group">
                <label for="update_nome">Nome:</label>
                <input type="text" class="form-control" id="update_nome" name="update_nome" value="<?php echo $edit_nome; ?>" required>
              </div>
              <div class="form-group">
                <label for="update_senha">Senha:</label>
                <input type="password" class="form-control" id="update_senha" name="update_senha" value="<?php echo $edit_senha; ?>" required>
              </div>
              <div class="form-group">
                <label for="update_role">Role:</label>
                <select class="form-control" id="update_role" name="update_role" required>
                  <option value="admin" <?php echo ($edit_role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                  <option value="usuario" <?php echo ($edit_role == 'usuario') ? 'selected' : ''; ?>>Usuário</option>
                </select>
              </div>
              <button type="submit" name="update" class="btn btn-primary btn-block">Atualizar</button>
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
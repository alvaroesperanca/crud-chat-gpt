<?php
// Conexão com o banco de dados (substitua pelos seus dados)
include_once "conexao.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $new_nome = $_POST["new_nome"];
    $new_senha = $_POST["new_senha"];
    $new_role = $_POST["new_role"];

    // Insere os dados no banco de dados
    $sql = "INSERT INTO usuarios (nome, senha, role) VALUES ('$new_nome', '$new_senha', '$new_role')";

    if ($conn->query($sql) === TRUE) {
        // Redireciona de volta para a página de cadastro
        header("Location: cadastro.php");
        exit();
    } else {
        echo "Erro ao cadastrar novo usuário: " . $conn->error;
    }
}

// Fecha a conexão
$conn->close();
?>

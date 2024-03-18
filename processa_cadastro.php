<?php
session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "biblioteca"; // Atualizado para o nome do banco de dados da biblioteca

    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        $mensagem = "Conexão falhou: " . $conn->connect_error;
    } else {
        // Coletar dados do formulário
        $autor = $conn->real_escape_string($_POST['autor']);
        $titulo = $conn->real_escape_string($_POST['titulo']);
        $descricao = $conn->real_escape_string($_POST['descricao']); 

        // Criar o comando SQL para inserir os dados
        $sql = "INSERT INTO livros (autor, titulo, descricao) VALUES ('$autor', '$titulo', '$descricao')";

        // Executar o comando SQL
        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro ao realizar cadastro: " . $conn->error;
        }
    }
    // Fechar conexão
    $conn->close();

    // Redirecionar para a página do formulário
    header("Location: cadastro.php");
    exit;
}
?>

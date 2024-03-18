<?php
session_start(); // Inicia a sessão

$erro = ""; // Inicializa a variável de erro

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['autor']) || empty($_POST['titulo']) || empty($_POST['descricao'])) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        require_once "processa_cadastro.php";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Livros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>

<div class="container">
    <img src="https://static.vecteezy.com/system/resources/thumbnails/013/083/736/small_2x/stick-man-with-book-shelves-in-library-education-and-learning-concept-3d-illustration-or-3d-rendering-png.png" alt="Biblioteca" class="header-image">
    <hr>
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center navbar-custom">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cadastro.php">Cadastro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="visualizar_cadastros.php">Visualizar</a>
            </li>
        </ul>
    </nav>
    <hr>
    <h1>Cadastro de Livros</h1>
</div>

<div class="card">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" class="form-control">
        </div>
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" class="form-control">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição do Livro:</label>
            <input type="text" id="descricao" name="descricao" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php elseif (isset($_SESSION['mensagem']) && !empty($_SESSION['mensagem'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?>
        </div>
    <?php endif; ?>
</div>

<div class="footer">
    © 2024 Biblioteca
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

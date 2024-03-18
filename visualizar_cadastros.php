<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o pedido de DELETE foi recebido
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM livros WHERE id = $id");
    header("Location: visualizar_cadastros.php");
}

// Processar a atualização dos dados via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    $sql = "UPDATE livros SET ".$column."='".$conn->real_escape_string($value)."' WHERE id=".$id;
    if ($conn->query($sql) === TRUE) {
        echo "Registro atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o registro: " . $conn->error;
    }
    exit; // Encerrar a execução após processar a requisição AJAX
}

// Exibir registros
$sql = "SELECT id, autor, titulo, descricao FROM livros";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visualizar Cadastros de Livros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="estilo.css">

    <script>
    function enableEditing(id) {
        var autorCell = document.getElementById('autor-' + id);
        var tituloCell = document.getElementById('titulo-' + id);
        var descricaoCell = document.getElementById('descricao-' + id);
        autorCell.contentEditable = true;
        tituloCell.contentEditable = true;
        descricaoCell.contentEditable = true;
        autorCell.focus();
    }

    function updateData(element, column, id) {
    var value = element.innerText;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Atualiza o elemento de mensagem de status em vez de exibir um alerta
            document.getElementById('statusMessage').innerText = this.responseText;
            // Opcional: limpa a mensagem após um certo tempo
            setTimeout(function() {
                document.getElementById('statusMessage').innerText = '';
            }, 3000); // Limpa após 3 segundos
        }
    };
    xhttp.open("POST", "visualizar_cadastros.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id + "&column=" + column + "&value=" + encodeURIComponent(value));
}


    function deleteRow(id) {
        var confirmDelete = confirm("Tem certeza que deseja excluir este registro?");
        if (confirmDelete) {
            window.location.href = 'visualizar_cadastros.php?delete=' + id;
        }
    }
    </script>



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
    <h1>Visualizar Cadastros de Livros</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Autor</th><th>Titulo</th><th>Descricao</th><th>Acoes</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td id='autor-" . $row["id"] . "' contentEditable='false' onBlur='updateData(this, \"autor\", ".$row["id"].")'>" . $row["autor"]. "</td><td id='titulo-" . $row["id"] . "' contentEditable='false' onBlur='updateData(this, \"titulo\", ".$row["id"].")'>" . $row["titulo"]. "</td><td id='descricao-" . $row["id"] . "' contentEditable='false' onBlur='updateData(this, \"descricao\", ".$row["id"].")'>" . $row["descricao"]. "</td><td>";
            echo "<button onClick='enableEditing(".$row["id"].")'>✏️</button> ";
            echo "<button onClick='deleteRow(".$row["id"].")'>🗑️</button>";
            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Ainda não há cadastro...";
    }
    ?>
</div>

<div class="footer">
    © 2024 Biblioteca
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

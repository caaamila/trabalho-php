<?php
$conn = new mysqli('localhost', 'root', '', 'gestao_alunos');
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT * FROM alunos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Alunos</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid oi">
	<div class="row">
		<div class="col-md-12">
                    <h1>Lista de Alunos</h1>
                    <button type="button" class="btn btn-info btn-block">
                     <a class="ole" href="adicionar.php">Adicionar Novo Aluno</a>
                    </button>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Contacto</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                                <tbody class="table-success">
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while($linha = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $linha['id'] . "</td>";
                                            echo "<td>" . $linha['nome'] . "</td>";
                                            echo "<td>" . $linha['email'] . "</td>";
                                            echo "<td>" . $linha['contacto'] . "</td>";
                                            echo "<td>
                                                <a href='editar.php?id=" . $linha['id'] . "'>Editar</a> | 
                                                <a href='eliminar.php?id=" . $linha['id'] . "' onclick='return confirm(\"Tens a certeza que desejas eliminar este registo?\")'>Eliminar</a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>Nenhum registo encontrado.</td></tr>";
                                    }
                                ?>
                                </tbody>
                        </table>
		</div>
	</div>
</div>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close();
?>
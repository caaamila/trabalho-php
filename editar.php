<?php
// Conexão à base de dados
$conn = new mysqli('localhost', 'root', '', 'gestao_alunos');
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obter dados atuais
    $stmt = $conn->prepare("SELECT * FROM alunos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $aluno = $resultado->fetch_assoc();
    $stmt->close();

    if (!$aluno) {
        echo "Aluno não encontrado!";
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $contacto = $_POST['contacto'];

    // Validar os dados
    if (empty($nome) || empty($email) || empty($contacto)) {
        echo "Todos os campos são obrigatórios.";
    } else {
        // Atualizar registo
        $stmt = $conn->prepare("UPDATE alunos SET nome = ?, email = ?, contacto = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome, $email, $contacto, $id);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<div class="container-fluid oi-editar">
	<div class="row">
		<div class="col-md-12">
        <h1>Editar Aluno</h1>
        <form method="post" action="">
            Nome: <input type="text" name="nome" value="<?php echo $aluno['nome']; ?>"><br><br>
            Email: <input type="email" name="email" value="<?php echo $aluno['email']; ?>"><br><br>
            Contacto: <input type="text" name="contacto" value="<?php echo $aluno['contacto']; ?>"><br><br>
            <input type="submit" value="Atualizar">
        </form>
        </div>
	</div>
</div>
    <br>
    <a href="index.php">Voltar à lista</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

<?php
$conn->close();
?>
<?php
session_start();

$conexao = mysqli_connect("localhost", "Paulo", "12345678", "gamecodebd");

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

if (!isset($_SESSION['teacherKey'])) {
    header("Location: login.html");
    exit;
}

$teacherKey = $_SESSION['teacherKey'];

$stmt = $conexao->prepare("SELECT * FROM alunos WHERE teacherKey = ?");
$stmt->bind_param("s", $teacherKey);
$stmt->execute();
$alunosResult = $stmt->get_result();

mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Professor</title>
    <link rel="stylesheet" href="../css/teacher.css">
</head>
<body>

    <header>
        <h1>Bem-vindo, Professor!</h1>
    </header>

    <section>
        <h2>Minha Chave</h2>
        <p><strong>Chave do Professor:</strong> <?php echo $teacherKey; ?></p>
    </section>

    <section>
        <h2>Alunos Vinculados</h2>
        <?php if ($alunosResult->num_rows > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($aluno = $alunosResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $aluno['id']; ?></td>
                            <td><?php echo $aluno['name']; ?></td>
                            <td><?php echo $aluno['surName']; ?></td>
                            <td><?php echo $aluno['email']; ?></td>
                            <td><?php echo $aluno['number']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você ainda não tem alunos vinculados.</p>
        <?php endif; ?>
    </section>

</body>
</html>

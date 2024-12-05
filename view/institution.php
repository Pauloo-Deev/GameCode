<?php
session_start();

if (!isset($_SESSION['institutionKey'])) {
    header('Location: login.php');
    exit;
}

$institutionKey = $_SESSION['institutionKey'];

$conexao = mysqli_connect("localhost", "Paulo", "12345678", "gamecodebd");
if (!$conexao) {
    die('Falha na conexão com o banco de dados.');
}

$queryInstitution = "SELECT * FROM instituicoes WHERE institutionKey = ?";
$stmtInstitution = $conexao->prepare($queryInstitution);
$stmtInstitution->bind_param("s", $institutionKey);
$stmtInstitution->execute();
$institutionResult = $stmtInstitution->get_result();

if ($institutionResult->num_rows > 0) {
    $institutionData = $institutionResult->fetch_assoc();
    $institutionName = $institutionData['institutionName'];
} else {
    die('Instituição não encontrada!');
}

$queryProfessores = "SELECT * FROM professores WHERE institutionKey = ?";
$stmtProfessores = $conexao->prepare($queryProfessores);
$stmtProfessores->bind_param("s", $institutionKey);
$stmtProfessores->execute();
$professoresResult = $stmtProfessores->get_result();

$queryAlunos = "SELECT * FROM alunos WHERE institutionKey = ?";
$stmtAlunos = $conexao->prepare($queryAlunos);
$stmtAlunos->bind_param("s", $institutionKey);
$stmtAlunos->execute();
$alunosResult = $stmtAlunos->get_result();

mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área da Instituição</title>
    <link rel="stylesheet" href="../css/institution.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($institutionName); ?>!</h1>
    </header>

    <div class="container">
        <section class="card">
            <h2>Chave da Instituição</h2>
            <p><strong>Chave da Instituição:</strong> <?php echo htmlspecialchars($institutionKey); ?></p>
        </section>

        <section class="card">
            <h2>Professores Vinculados</h2>
            <?php if ($professoresResult->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($professor = $professoresResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($professor['name']); ?></td>
                                <td><?php echo htmlspecialchars($professor['email']); ?></td>
                                <td><?php echo htmlspecialchars($professor['number']); ?></td>
                                <td>
                                    <a href="register.php?id=<?php echo $professor['id']; ?>" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="excluir_professor.php?id=<?php echo $professor['id']; ?>" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este professor?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Não há professores vinculados a esta instituição.</p>
            <?php endif; ?>
        </section>

        <section class="card">
            <h2>Alunos Vinculados</h2>
            <?php if ($alunosResult->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($aluno = $alunosResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aluno['name']); ?></td>
                                <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                                <td><?php echo htmlspecialchars($aluno['number']); ?></td>
                                <td>
                                    <a href="editar_aluno.php?id=<?php echo $aluno['id']; ?>" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="excluir_aluno.php?id=<?php echo $aluno['id']; ?>" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Não há alunos vinculados a esta instituição.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>

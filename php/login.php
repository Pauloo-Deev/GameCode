<?php
$conexao = mysqli_connect("localhost", "Paulo", "12345678", "gamecodebd");
if (!$conexao) {
    die('Falha na conexão com o banco de dados.');
}

$email = $_GET['email'] ?? null;
$password = $_GET['password'] ?? null;

if (!$email || !$password) {
    die('E-mail ou senha não fornecidos.');
}

$tabelas = ['alunos', 'professores', 'instituicoes'];
$loginSuccess = false;
$tipoUsuario = null;
$teacherKey = null;
$institutionKey = null;

foreach ($tabelas as $tabela) {
    $query = "SELECT email, password FROM $tabela WHERE email = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password === $user['password']) {
                $loginSuccess = true;
                $tipoUsuario = $tabela;
                
                if ($tabela === 'professores') {
                    $teacherKeyQuery = "SELECT teacherKey FROM professores WHERE email = ?";
                    $teacherStmt = $conexao->prepare($teacherKeyQuery);
                    $teacherStmt->bind_param("s", $email);
                    $teacherStmt->execute();
                    $teacherResult = $teacherStmt->get_result();
                    if ($teacherResult->num_rows > 0) {
                        $teacherData = $teacherResult->fetch_assoc();
                        $teacherKey = $teacherData['teacherKey'];
                    }
                }
                
                if ($tabela === 'instituicoes') {
                    $institutionKeyQuery = "SELECT institutionKey FROM instituicoes WHERE email = ?";
                    $institutionStmt = $conexao->prepare($institutionKeyQuery);
                    $institutionStmt->bind_param("s", $email);
                    $institutionStmt->execute();
                    $institutionResult = $institutionStmt->get_result();
                    if ($institutionResult->num_rows > 0) {
                        $institutionData = $institutionResult->fetch_assoc();
                        $institutionKey = $institutionData['institutionKey'];
                    }
                }

                break;
            }
        }
    }
}

if ($loginSuccess) {
    session_start();
    $_SESSION['userEmail'] = $email;
    if ($tipoUsuario === 'alunos') {
        header('Location: ../view/student.php');
    } elseif ($tipoUsuario === 'professores') {
        $_SESSION['teacherKey'] = $teacherKey;
        header('Location: ../view/teacher.php');
    } elseif ($tipoUsuario === 'instituicoes') {
        $_SESSION['institutionKey'] = $institutionKey;
        header('Location: ../view/institution.php');
    }
    exit;
} else {
    echo "E-mail ou senha incorretos!";
}

mysqli_close($conexao);
?>

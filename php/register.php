<?php
header('Content-Type: application/json');

$conexao = mysqli_connect("localhost", "Paulo", "12345678", "gamecodebd");
if (!$conexao) {
    die(json_encode(['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        $selectOption = $data['selectOption'] ?? null;
        $id = $data['id'] ?? uniqid();
        $name = $data['name'] ?? null;
        $surName = $data['surName'] ?? null;
        $email = $data['email'] ?? null;
        $number = $data['number'] ?? null;
        $teacherKey = $data['teacherKey'] ?? null;
        $institutionKey = $data['institutionKey'] ?? null;
        $password = $data['password'] ?? null;
        $passwordConfirm = $data['passwordConfirm'] ?? null;

        if (!$selectOption || !$name || !$email || !$password || !$passwordConfirm) {
            echo json_encode(['status' => 'error', 'message' => 'Dados incompletos.']);
            exit;
        }

        if ($selectOption == "student") {
            $table = "alunos";
        } elseif ($selectOption == "teacher") {
            $table = "professores";
        } elseif ($selectOption == "institution") {
            $table = "instituicoes";
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Opção inválida.']);
            exit;
        }

        $stmt = $conexao->prepare("INSERT INTO $table (id, selectOption, name, surName, email, number, teacherKey, institutionKey, password, passwordConfirm) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $id, $selectOption, $name, $surName, $email, $number, $teacherKey, $institutionKey, $password, $passwordConfirm);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => ucfirst($selectOption) . ' cadastrado com sucesso!',
                'data' => $data
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar no banco de dados.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao decodificar o JSON.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido.']);
}

mysqli_close($conexao);
?>

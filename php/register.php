<?php
header('Content-Type: application/json');

$conexao = mysqli_connect("localhost", "Paulo", "12345678", "gamecodebd");
if (!$conexao) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        $passwordConfirm = $data['passwordConfirm'] ?? null;
        $institutionName = $data['institutionName'] ?? null;
        $institutionKey = $data['institutionKey'] ?? null;
        $selectOption = $data['selectOption'] ?? null;
        $teacherKey = $data['teacherKey'] ?? null;
        $password = $data['password'] ?? null;
        $surName = $data['surName'] ?? null;
        $number = $data['number'] ?? null;
        $email = $data['email'] ?? null;
        $state = $data['state'] ?? null;
        $name = $data['name'] ?? null;
        $CNPJ = $data['CNPJ'] ?? null;
        $city = $data['city'] ?? null;
        $id = $data['id'] ?? uniqid();
        $CPF = $data['CPF'] ?? null;

        function gerarInstitutionKey() {
            return rand(100, 999) . '-' . rand(100, 999);
        }
        function gerarTeacherKey() {
            return rand(100, 999) . '-' . rand(100, 999);
        }

        if ($selectOption == "student") {
            if ($institutionKey) {
                $stmt = $conexao->prepare("SELECT * FROM instituicoes WHERE institutionKey = ?");
                $stmt->bind_param("s", $institutionKey);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 0) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Instituição com essa chave não encontrada.']);
                    exit;
                }
                $stmt->close();
            }

            if ($teacherKey) {
                $stmt = $conexao->prepare("SELECT * FROM professores WHERE teacherKey = ?");
                $stmt->bind_param("s", $teacherKey);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 0) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Professor com essa chave não encontrado.']);
                    exit;
                }
                $stmt->close();
            }

            if (!$institutionKey && !$teacherKey) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Chave da instituição ou do professor é necessária.']);
                exit;
            }

            $table = 'alunos';
            $stmt = $conexao->prepare("INSERT INTO $table (id, selectOption, name, surName, email, number, teacherKey, institutionKey, password, passwordConfirm) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $id, $selectOption, $name, $surName, $email, $number, $teacherKey, $institutionKey, $password, $passwordConfirm);
        } elseif ($selectOption == "teacher") {
            if (empty($teacherKey)) {
                $teacherKey = gerarTeacherKey();
            }

            if ($institutionKey) {
                $stmt = $conexao->prepare("SELECT * FROM instituicoes WHERE institutionKey = ?");
                $stmt->bind_param("s", $institutionKey);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 0) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Instituição com essa institutionKey não encontrada.']);
                    exit;
                }
                $stmt->close();
            } else {
                $institutionKey = null;
            }

            $table = 'professores';
            $stmt = $conexao->prepare("INSERT INTO $table (id, selectOption, name, surName, email, number, CPF, institutionKey, password, passwordConfirm, teacherKey) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $id, $selectOption, $name, $surName, $email, $number, $CPF, $institutionKey, $password, $passwordConfirm, $teacherKey);
        } elseif ($selectOption == "institution") {
            if (empty($institutionKey)) {
                $institutionKey = gerarInstitutionKey();
            }

            $table = 'instituicoes';
            $stmt = $conexao->prepare("INSERT INTO $table (id, selectOption, institutionName, CNPJ, email, number, city, state, password, passwordConfirm, institutionKey) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $id, $selectOption, $institutionName, $CNPJ, $email, $number, $city, $state, $password, $passwordConfirm, $institutionKey);
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Opção inválida.']);
            exit;
        }

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success',
                'message' => ucfirst($selectOption) . ' cadastrado com sucesso!',
                'data' => $data
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar no banco de dados: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Erro ao decodificar o JSON.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido.']);
}

mysqli_close($conexao);
?>

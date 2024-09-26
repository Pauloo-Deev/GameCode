<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        $filePath = 'data.json';

        if (file_exists($filePath)) {
            $existingData = json_decode(file_get_contents($filePath), true);
            if (!is_array($existingData)) {
                $existingData = [];
            }
        } else {
            $existingData = [];
        }

        $newId = uniqid('id_', true);

        $data['id'] = $newId;
        $existingData[] = $data;

        if (file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT))) {
            $response = [
                'status' => 'success',
                'message' => 'Dados recebidos e salvos com sucesso!',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Erro ao salvar os dados no arquivo.'
            ];
        }

        echo json_encode($response);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Erro ao decodificar o JSON.'
        ];
        echo json_encode($response);
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Método não permitido.'
    ];
    echo json_encode($response);
}
?>

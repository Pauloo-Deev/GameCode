<?php
    $email = $_GET['email'];
    $password = $_GET['password'];

    $json = file_get_contents('data.json');
    $users = json_decode($json, true);

    $login_success = false;

    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            $login_success = true;
            break;
        }
    }

    if ($login_success) {
        echo "Login realizado com sucesso!";
    } else {
        echo "E-mail ou senha incorretos!";
    }
?>

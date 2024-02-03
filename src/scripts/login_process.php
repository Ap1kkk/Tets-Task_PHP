<?php
    require_once "../shared/global_entities.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $result = $authenticator->loginUserByEmail($email, $password);

        if ($result) {
            header("Location: ../pages/user_profile.php");
            exit();
        } else {
            $errorMessage = "Неверный логин или пароль";
            setcookie('loginError', $errorMessage, time() + 60, '/');
            header("Location: ../pages/login.php");
            exit();
        }
    }
?>
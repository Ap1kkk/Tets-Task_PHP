<?php
    require_once "../shared/global_entities.php";
    require_once "../shared/authentication_required.php";

    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = $_POST['userId'];
            $role = $_POST['role'];
            $fio = $_POST['fio'];
            $status = $_POST['status'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $house = $_POST['house'];
            $flat = $_POST['flat'];
            $login = $_POST['login'];
            $password = $_POST['password'];

            $user = new User($role ,$fio,  $status, $email, $phone, $city, $street, $house, $flat, $login, $password, $userId);

            $updateResult = $authenticator->updateUser($user);

            if ($updateResult) {
                header('Location: ../pages/user_profile.php');
            } else {
                echo "Ошибка при редактировании пользователя";
            }
        }
    } catch (Exception $e) {
        echo "Ошибка: {$e->getMessage()}";
    }
?>

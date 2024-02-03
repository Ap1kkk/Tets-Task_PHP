<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require "../../vendor/phpmailer/phpmailer/src/Exception.php";
    require "../../vendor/phpmailer/phpmailer/src/PHPMailer.php";
    require "../../vendor/phpmailer/phpmailer/src/SMTP.php";

    require_once "../shared/global_entities.php";

    $mail = new PHPMailer(true);

    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

            $user = new User(RoleEnum::USER ,$fio,  $status, $email, $phone, $city, $street, $house, $flat, $login, $password);

            $registrationResult = $authenticator->registerUser($user);

            if ($registrationResult) {
                sendEmailToAdmin($userData);  //    <-----------------
                header('Location: ../pages/login.php');
            } else {
                echo "Ошибка при регистрации пользователя";
            }
        }
    } catch (Exception $e) {
        echo "Ошибка: {$e->getMessage()}";
    }

    function sendEmailToAdmin($userData) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ap1kdungeonmaster2@gmail.com';
            $mail->Password   = 'bamg vhco qfif lkmb';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('ap1kdungeonmaster2@gmail.com', 'Mailer');
            $mail->addAddress('ApikMaster2@yandex.ru');
            $mail->Subject = 'Новый пользователь зарегистрирован';
            $mail->Body    = "Зарегистрирован новый пользователь:\n\n" .
                            "ФИО: " . $userData['fio'] . "\n" .
                            "E-mail: " . $userData['email'] . "\n" .
                            "Телефон: " . $userData['phone'] . "\n";

            $mail->send();
        } catch (Exception $e) {
            echo "Ошибка при отправке письма: {$mail->ErrorInfo}";
        }
    }
?>

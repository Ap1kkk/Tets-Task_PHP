<?php
    require_once "global_entities.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="http://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=7e6efc92-e8e2-472d-a8ed-768f99334814&lang=ru_RU" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Test task</title>
</head>
<body>

<?php 
    $user = $authenticator->getCurrentUser();
?>

<nav class="navbar navbar-expand-sm navbar-light bg-light p-2">


    <?php if($user):?>
        <a class="navbar-brand" href="#">Привет, <?php echo $user->fio; ?>!</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../scripts/logout_process.php">Выйти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_profile.php">Профиль</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php">Товары</a>
                </li>
            </ul>
        </div>
    <?php else:?>
        <a class="navbar-brand" href="#">Test Task</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="registration.php">Регистрация</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Войти</a>
                </li>
            </ul>
        </div>
    <?php endif;?>
    <?php if($user && $user->role === RoleEnum::ADMIN):?>
        <a class="navbar-brand" href="admin_profile.php">Профиль администратора</a>
    <?php endif;?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

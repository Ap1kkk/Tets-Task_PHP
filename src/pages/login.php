<?php
    require_once "../scripts/login_process.php";
    require_once "../shared/header.php";

    $errorMessage = isset($_COOKIE['loginError']) ? $_COOKIE['loginError'] : null;
?>

<div class="container mt-5">
    <h2>Вход</h2>

    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; 
        setcookie('loginError', '', time() - 3600, '/');
    ?>

    <form method="post" action="../scripts/login_process.php">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-success my-2">Войти</button>
        <a href="registration.php" class="btn btn-outline-secondary">Зарегистрироваться</a>
    </form>
</div>

<?php

    require_once "../shared/footer.php";
?>
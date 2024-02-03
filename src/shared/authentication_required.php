<?php
    require_once "global_entities.php";
    
    if (!$authenticator->getCurrentUser()) {
        echo "<script>alert('Авторизуйтесь, чтобы попасть на страницу')</script>";
        header("Refresh: 0.1; ../pages/login.php");
        exit();
    }
?>
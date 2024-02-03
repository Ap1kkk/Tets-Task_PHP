<?php
    require_once "authentication_required.php";
    
    if ($authenticator->getCurrentUser()->role !== RoleEnum::ADMIN) {
        echo "<script>alert('У вас нет доступа к данной странице')</script>";
        header("Refresh: 0.1;  ../pages/user_profile.php");
        exit();
    }
?>
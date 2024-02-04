<?php
    require_once "src/shared/global_entities.php";

    $user = $authenticator->getCurrentUser();

    if($user) {
        header("Location: src/pages/user_profile.php");
    }
    else {
        header("Location: src/pages/login.php");
    }
?>
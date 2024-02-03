<?php
    require_once "../shared/global_entities.php";

    $authenticator->logout();
    header("Location: ../pages/login.php");
?>
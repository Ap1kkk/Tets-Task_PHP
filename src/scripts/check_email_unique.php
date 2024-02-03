<?php 
    require_once "../shared/global_entities.php";

    $email = $_GET['email'];
    $userId = isset($_GET['userId']) ? $_GET['userId'] : null;

    echo json_encode($userService->isEmailUnique($email, $userId));
?>
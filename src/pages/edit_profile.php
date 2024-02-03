<?php 
    require_once "../shared/authentication_required.php";

    require_once "../shared/header.php";

    $userId = isset($_GET['userId']) ? $_GET['userId'] : $authenticator->getCurrentUser()->id;
    $submitButtonValue = "Сохранить изменения";
    $formAction = "update_profile.php";
    require "../shared/form.php";

    require_once "../shared/footer.php";
?>
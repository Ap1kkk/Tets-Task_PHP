<?php
    require_once "../model/Database.php";
    require_once "../model/UserService.php";
    require_once "../model/ProductService.php";
    require_once "../model/Authenticator.php";

    $database = new Database();

    $userService = new UserService($database);
    $productService = new ProductService($database);

    $authenticator = new Authenticator($userService);
?>
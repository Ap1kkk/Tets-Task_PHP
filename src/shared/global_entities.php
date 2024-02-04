<?php
    require_once __DIR__ . "/../model/Database.php";
    require_once __DIR__ . "/../model/UserService.php";
    require_once __DIR__ . "/../model/ProductService.php";
    require_once __DIR__ . "/../model/Authenticator.php";

    $database = new Database();

    $userService = new UserService($database);
    $productService = new ProductService($database);

    $authenticator = new Authenticator($userService);
?>
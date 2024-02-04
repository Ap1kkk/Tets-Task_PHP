<?php
    require_once "../shared/global_entities.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        $isDeleted = $productService->deleteProduct($productId);

        if ($isDeleted) {
            header("Location: ../pages/product_management.php");
            exit();
        } else {
            echo "Ошибка удаления товара.";
        }
    }
?>

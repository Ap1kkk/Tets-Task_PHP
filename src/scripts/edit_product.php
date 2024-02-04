<?php
require_once "../shared/global_entities.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = "../../uploads/";

    $productId = $_POST["product_id"];
    $name = $_POST["product_name"];
    $description = $_POST["product_description"];
    $priceForJuridical = $_POST["price_juridical"];
    $priceForPhysical = $_POST["price_physical"];

    // Получаем текущую информацию о товаре, чтобы получить путь к текущему изображению
    $currentProduct = $productService->getProductById($productId);
    $currentImagePath = $currentProduct->image;

    if ($_FILES["product_image"]["error"] == UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES["product_image"]["tmp_name"];
        $imageExtension = pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION);
        
        $uniqueImageName = uniqid() . "." . $imageExtension;

        $imagePath = $uploadDir . $uniqueImageName;

        move_uploaded_file($imageTmpName, $imagePath);

        // Обновляем информацию о товаре, включая новый путь к изображению
        $updatedProduct = new Product($name, $description, $priceForJuridical, $priceForPhysical, $productId, $imagePath);

        // Удаляем старое изображение
        if (!empty($currentImagePath)) {
            unlink($currentImagePath);
        }
    } else {
        // Если новый файл изображения не был загружен, обновляем информацию о товаре без изменения изображения
        $updatedProduct = new Product($name, $description, $priceForJuridical, $priceForPhysical, $productId, $currentImagePath);
    }

    $success = $productService->updateProduct($updatedProduct);

    if ($success) {
        header("Location: ../pages/product_management.php");
        exit();
    } else {
        echo "Ошибка при редактировании товара.";
    }
}
?>

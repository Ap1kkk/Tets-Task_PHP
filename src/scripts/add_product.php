<?php
    require_once "../shared/global_entities.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uploadDir = "../../uploads/";

        $name = $_POST["product_name"];
        $description = $_POST["product_description"];
        $priceForJuridical = $_POST["price_juridical"];
        $priceForPhysical = $_POST["price_physical"];

        if ($_FILES["product_image"]["error"] == UPLOAD_ERR_OK) {
            $imageTmpName = $_FILES["product_image"]["tmp_name"];
            $imageExtension = pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION);
            
            $uniqueImageName = uniqid() . "." . $imageExtension;

            $imagePath = $uploadDir . $uniqueImageName;

            move_uploaded_file($imageTmpName, $imagePath);
        } else {
            echo "Ошибка загрузки файла. Error code: " . $_FILES["product_image"]["error"];
            exit();
        }

        $newProduct = new Product($name, $description, $priceForJuridical, $priceForPhysical, null, $imagePath);

        $addedProduct = $productService->addProduct($newProduct);

        if ($addedProduct) {
            header("Location: ../pages/product_management.php");
            exit();
        } else {
            echo "Ошибка добавления товара товара.";
        }
    }
?>

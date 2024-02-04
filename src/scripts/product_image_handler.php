<?php
    require_once "../shared/global_entities.php";

    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        $productImage = $productService->getProductImage($productId);

        if ($productImage) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_buffer($finfo, $productImage);
            finfo_close($finfo);

            header("Content-Type: image/jpeg");

            echo base64_encode($productImage);
            exit();
        }
    }
?>

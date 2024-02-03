<?php
    require_once "../shared/authentication_required.php";
    require_once "../shared/header.php";

    $user = $authenticator->getCurrentUser();
    $products = $productService->getAllProducts();
?>
<h2>Список продуктов</h2>

<?php if (!empty($products)): ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Цена</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product->id ?></td>
                <td><?= $product->name?></td>
                <td><?= $product->description ?></td>
                <td><?= $user->status === StatusEnum::JURIDICAL ? $product->priceForJuridical: $product->priceForPhysical; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Нет доступных продуктов.</p>
<?php endif; ?>

<?php

    require_once "../shared/footer.php";
?> 
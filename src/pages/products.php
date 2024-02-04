<?php
    require_once "../shared/authentication_required.php";
    require_once "../shared/header.php";

    $user = $authenticator->getCurrentUser();
    $products = $productService->getAllProducts();
?>
<div class="container mt-5">
    <h2>Список продуктов</h2>

    <?php if (!empty($products)): ?>
        <div class="row mt-3">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= $product->image ?>" class="card-img-top" alt="<?= $product->name ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product->name ?></h5>
                            <p class="card-text"><?= $product->description ?></p>
                            <p class="card-text">
                                Цена: <?= $user->status === StatusEnum::JURIDICAL ? $product->priceForJuridical : $product->priceForPhysical; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Нет доступных продуктов.</p>
    <?php endif; ?>
</div>


<?php

    require_once "../shared/footer.php";
?> 
<?php
    require_once "../shared/admin_required.php";
    require_once "../shared/header.php";

    $products = $productService->getAllProducts();
?>

<div class="container mt-5">
    <h2>Управление товарами (администратор)</h2>

    <!-- Кнопки навигации -->
    <div class="btn-group mt-3">
        <button class="btn btn-outline-success" data-toggle="modal" data-target="#addProductModal">Добавить товар</button>
    </div>

    <!-- Модальное окно для добавления товара -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Добавить товар</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-pressed="false" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Форма добавления товара -->
                    <form method="post" action="../scripts/add_product.php" id="addProductForm" enctype="multipart/form-data">
                        <div class="form-group mt-3">
                            <label for="product_name">Название:</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="product_description">Описание:</label>
                            <textarea name="product_description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="price_juridical">Цена для юридических лиц:</label>
                            <input type="number" name="price_juridical" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="price_physical">Цена для физических лиц:</label>
                            <input type="number" name="price_physical" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <img id="image_preview" src="#" alt="Превью" style="max-width: 100px; max-height: 100px; display: none;">
                            <input type="file" id="product_image" name="product_image" accept="image/*" required>
                        </div>
                        <button type="submit" name="add_product" class="btn btn-outline-success mt-3">Добавить товар</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Отображение карточек товаров -->
    <div class="row mt-3">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?=$product->image?>" class="card-img-top" alt="<?= $product->name ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product->name ?></h5>
                        <p class="card-text"><?= $product->description ?></p>
                        <p class="card-text">
                            Цена (Юр. лицо): <?= $product->priceForJuridical; ?>
                        </p>
                        <p class="card-text">
                            Цена (Физ. лицо): <?= $product->priceForPhysical; ?>
                        </p>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#confirmDeleteModal<?= $product->id ?>">
                            <i class="fas fa-times"></i> Удалить
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#editProductModal<?= $product->id ?>">
                            <i class="fas fa-edit"></i> Редактировать
                        </button>
                    </div>
                </div>

                <!-- Модальное окно для подтверждения удаления каждого товара -->
                <div class="modal fade" id="confirmDeleteModal<?= $product->id ?>" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Подтверждение удаления</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Вы уверены, что хотите удалить товар "<?= $product->name ?>"?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                <form method="post" action="../scripts/delete_product.php">
                                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                    <button type="submit" name="delete_product" class="btn btn-danger">Удалить товар</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Модальное окно для редактирования товара -->
                <div class="modal fade" id="editProductModal<?= $product->id ?>" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductModalLabel">Редактировать товар</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-pressed="false" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Форма редактирования товара -->
                                <form method="post" action="../scripts/edit_product.php" id="editProductForm" enctype="multipart/form-data">
                                    <!-- Добавьте поля для редактирования данных товара (название, описание, цены, изображение) -->
                                    <!-- Пример: -->
                                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                    <div class="form-group mt-3">
                                        <label for="product_name">Название:</label>
                                        <input type="text" name="product_name" class="form-control" value="<?= $product->name ?>" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="product_description">Описание:</label>
                                        <textarea name="product_description" class="form-control" required><?= $product->description ?></textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="price_juridical">Цена для юридических лиц:</label>
                                        <input type="number" name="price_juridical" class="form-control" value="<?= $product->priceForJuridical ?>" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="price_physical">Цена для физических лиц:</label>
                                        <input type="number" name="price_physical" class="form-control" value="<?= $product->priceForPhysical ?>" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="product_image">Изображение:</label>
                                        <img id="edit_image_preview" src="<?= $product->image ?>" alt="Превью" style="max-width: 100px; max-height: 100px;">
                                        <input type="file" id="edit_product_image" class="mt-3" name="product_image" accept="image/*">
                                    </div>
                                    <button type="submit" name="edit_product" class="btn btn-outline-success mt-3">Сохранить изменения</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.getElementById('product_image').addEventListener('change', function(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function(){
        var img = document.getElementById('image_preview');
        img.src = reader.result;
        img.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
});

document.getElementById('edit_product_image').addEventListener('change', function(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function(){
        var img = document.getElementById('edit_image_preview');
        img.src = reader.result;
        img.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
});

function getValidation(emailRequired) {
    return {
            rules: {
                product_name: {
                    required: true
                },
                product_description: {
                    required: true
                },
                price_juridical: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                price_physical: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                product_image: {
                    required: emailRequired,
                    accept: "image/*"
                }
            },
            messages: {
                product_name: "Заполните имя товара",
                product_description: "Заполните описание товара",
                price_juridical: {
                    required: "Заполните цену для юридических лиц",
                    number: "Введите корректное число",
                    min: "Цена должна быть больше 0"
                },
                price_physical: {
                    required: "Заполните цену для физических лиц",
                    number: "Введите корректное число",
                    min: "Цена должна быть больше 0"
                },
                product_image: {
                    required: "Выберите изображение",
                    accept: "Выберите изображение в формате (jpg, jpeg, png, gif)"
                }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass("is-invalid");
            }
        }
}
$(document).ready(function() {
    $("#addProductForm").validate(getValidation(true));
    $("#editProductForm").validate(getValidation(false));
});
</script>

<?php require_once "../shared/footer.php"; ?>

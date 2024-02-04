<?php
    require_once "../shared/admin_required.php";

    require_once "../shared/header.php";

    $admin = $authenticator->getCurrentUser();

    $users = $userService->getAllUsers();
?>

<div class="row m-5">
    <div class="col-12">
        <h2>Управление товарами</h2>
        <a href="product_management.php" class="btn btn-outline-info">Перейти к управлению товарами</a>
    </div>
</div>


<div class="container mt-5">
    <h2>Все пользователи</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Роль</th>
                <th>ФИО</th>
                <th>Email</th>
                <th>Телефон</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <a href="edit_profile.php?userId=<?= $user->id ?>">
                            <?php echo $user->id; ?>
                        </a>
                    </td>
                    <td><?php echo $user->role; ?></td>
                    <td><?php echo $user->fio; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo $user->phone; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="row m-5">
    <div class="col-12">
        <h2>Карта пользователей</h2>
        <div id="map" style="height: 400px;"></div>
    </div>
</div>

<script>
    ymaps.ready(init);

    function init() {

        var myMap = new ymaps.Map('map', {
            center: [55.7558, 37.6176], // Центр Москвы
            zoom: 10
        });

        var address = "<?= $admin->getFullAddress() ?>";

        var geocoder = ymaps.geocode(address);

        <?php foreach ($users as $user): ?>
            ymaps.geocode("<?= $user->getFullAddress() ?>").then(
                function (result) {
                    var coordinates = result.geoObjects.get(0).geometry.getCoordinates();

                    // Создаем метку и добавляем на карту
                    var placemark<?=$user->id?> = new ymaps.Placemark(coordinates, {
                        balloonContent: '<?= $user->fio ?>'
                    });
                    myMap.geoObjects.add(placemark<?=$user->id?>);
                },
                function (error) {
                    alert("Ошибка при геокодировании: " + error.message);
                }
            );
        <?php endforeach; ?>
    }

</script>
<?php

    require_once "../shared/footer.php";
?>
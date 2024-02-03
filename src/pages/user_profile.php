<?php 
    require_once "../shared/authentication_required.php";
    
    require_once "../shared/header.php";

    $currentUser = $authenticator->getCurrentUser();

    $userId = isset($_GET['userId']) ? $_GET['userId'] : $currentUser->id;

    $displayingUser = null;

    if($currentUser->id === $userId ) {
        $displayingUser = $currentUser;
    }
    else {
        if($currentUser->role === RoleEnum::ADMIN) {
            $displayingUser = $userService->getUserById($userId);
        }
        else {
            echo("<h1>Профиль не найден</h1>");
            exit;
        }
    }    
?>

<div class="container mt-5">
    <h2>Личный кабинет</h2>

    <p>Роль: <?= $displayingUser->role; ?></p>
    <p>ФИО: <?= $displayingUser->fio; ?></p>
    <p>Статус: <?echo ($displayingUser->status == StatusEnum::JURIDICAL) ? 'Юридическое лицо' : 'Физическое лицо';?></p>
    <p>E-mail: <?= $displayingUser->email; ?></p>
    <p>Телефон: <?= $displayingUser->phone; ?></p>
    <p>Город: <?= $displayingUser->city;?></p>
    <p>Улица: <?= $displayingUser->street; ?></p>
    <p>Дом: <?= $displayingUser->house; ?></p>
    <p>Квартира: <?= $displayingUser->flat; ?></p>
    <p>Логин: <?= $displayingUser->login; ?></p>
    <p>Пароль: <?= $displayingUser->password; ?></p>

    <a href="edit_profile.php"><button class="btn btn-outline-secondary">Редактировать профиль</button></a>
    <a href="../scripts/logout_process.php"><button class="btn btn-outline-danger">Выйти</button></a>
    
    <div class="row m-5">
        <div class="col-12">
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>
</div>

<?php 
    require_once "../shared/footer.php";
?>

<script>

    $("#editProfileButton").click(function() {
        $.ajax({
            type: "POST",
            url: "edit_profile.php",
            success: function(response) {
                console.log("Успешно:", response);
            },
            error: function(error) {
                console.log("Ошибка:", error);
            }
        });
    });

    ymaps.ready(init);

    function init() {
        var address = "<?= $displayingUser->city ?>, <?= $displayingUser->street ?>, <?= $displayingUser->house ?>, <?= $displayingUser->flat ?>";

        var geocoder = ymaps.geocode(address);

        geocoder.then(
            function (result) {
                var coordinates = result.geoObjects.get(0).geometry.getCoordinates();

                var myMap = new ymaps.Map("map", {
                    center: coordinates,
                    zoom: 10
                });

                var myPlacemark = new ymaps.Placemark(coordinates);
                myMap.geoObjects.add(myPlacemark);
            },
            function (error) {
                alert("Ошибка при геокодировании: " + error.message);
            }
        );
    }
</script>
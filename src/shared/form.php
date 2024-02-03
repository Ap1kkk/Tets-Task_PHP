<!-- 
    Require:
    ->$userId
    ->$formAction
    ->$submitButtonValue 
-->
<?php 
    require_once "global_entities.php";

    $user = isset($userId) ? $userService->getUserById($userId) : null;
    $currentUser =$authenticator->getCurrentUser();
?>
<script>var userId = <?= isset($userId) ? $userId: "''";?>;</script>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form id="form" action="../scripts/<?=$formAction?>" method="post">
                <!-- Скрытое поле с userId -->
                <input type="hidden" id="userId" name="userId" value="<?= isset($userId) ? $userId : "" ?>" required>

                <div class="form-group <?= $currentUser && $currentUser->role === RoleEnum::ADMIN ? "" : "d-none";?>">
                    <label for="role">Роль:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="<?=RoleEnum::ADMIN?>" <?= (isset($user) && $user->role == RoleEnum::ADMIN) ? 'selected' : ''; ?>>Администратор</option>
                        <option value="<?=RoleEnum::USER?>" <?= (isset($user) && $user->role == RoleEnum::USER) ? 'selected' : ''; ?>>Пользователь</option>
                    </select>
                </div>         
                <!-- ФИО -->
                <div class="form-group">
                    <label for="fio">ФИО:</label>
                    <input type="text" class="form-control" id="fio" name="fio" value="<?= isset($user) ? $user->fio : ""; ?>" required>
                </div>

                <!-- Статус -->
                <div class="form-group">
                    <label for="status">Статус:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="<?=StatusEnum::JURIDICAL?>" <?= (isset($user) && $user->status == StatusEnum::JURIDICAL) ? 'selected' : ''; ?>>Юридическое лицо</option>
                        <option value="<?=StatusEnum::PHYSICAL?>" <?= (isset($user) && $user->status == StatusEnum::PHYSICAL) ? 'selected' : ''; ?>>Физическое лицо</option>
                    </select>
                </div>

                <!-- E-mail -->
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= isset($user) ? $user->email : ""; ?>" required>
                </div>

                <!-- Телефон -->
                <div class="form-group">
                    <label for="phone">Телефон:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{11}" value="<?= isset($user) ? $user->phone : ""; ?>" required>
                </div>

                <!-- Полный адрес -->
                <div class="form-group">
                    <label for="address">Полный адрес:</label>
                    <input type="text" class="form-control" id="address" name="address" autocomplete="off"/>
                </div>

                <!-- Город -->
                <div class="form-group">
                    <label for="city">Город:</label>
                    <input type="text" class="form-control" id="city" name="city" value="<?= isset($user) ? $user->city : ""; ?>" required>
                </div>

                <!-- Улица -->
                <div class="form-group">
                    <label for="street">Улица:</label>
                    <input type="text" class="form-control" id="street" name="street" value="<?= isset($user) ? $user->street : ""; ?>" required>
                </div>

                <!-- Дом -->
                <div class="form-group">
                    <label for="house">Дом:</label>
                    <input type="text" class="form-control" id="house" name="house" value="<?= isset($user) ? $user->house : ""; ?>" required>
                </div>

                <!-- Квартира -->
                <div class="form-group">
                    <label for="flat">Квартира:</label>
                    <input type="text" class="form-control" id="flat" name="flat" value="<?= isset($user) ? $user->flat : ""; ?>">
                </div>

                <!-- Логин -->
                <div class="form-group">
                    <label for="login">Логин:</label>
                    <input type="text" class="form-control" id="login" name="login" value="<?= isset($user) ? $user->login : ""; ?>" required>
                </div>

                <!-- Пароль -->
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?= isset($user) ? $user->password : ""; ?>" required>
                </div>

                <!-- reCAPTCHA -->
                <div class="form-group">
                    <div id="capthca" class="g-recaptcha" data-sitekey="6Ld2D2MpAAAAALgSQmYufg8o5h4Qna73dGLSsMxU" data-callback="onCaptchaDone"></div>
                </div>

                <!-- Кнопка отправки формы -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="submitButton"><?=$submitButtonValue?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var token = "8a033d3727d2eef4fea1010f6c3c265051511f76";
var reCaptchaKey = "6Ld2D2MpAAAAALgSQmYufg8o5h4Qna73dGLSsMxU";
var type  = "ADDRESS";
var isCapthcaDone = false;

$form = $('#form');

$fio = $("#fio");
$email = $('#email');
$phone = $('#phone');
$address = $("#address");
$city = $("#city");
$street = $("#street");
$house = $("#house");
$flat = $("#flat");
$login = $('#login');

$.validator.addMethod("phone", function(value, element) {
    var phoneRegex = /^(\+7|8)\s?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{2}[-.\s]?\d{2}$/;
    return this.optional(element) || phoneRegex.test(value);
}, "Введите корректный номер телефона");

$.validator.addMethod("capthca", function(value, element) {
    return this.optional(element) || isCapthcaDone;
}, "Пройдите капчу");

$.validator.addMethod("uniqueEmail", function(value, element) {
    var isEmailValid = false;

    data = {email: value}

    if(userId != "")
        data = {email: value, userId: userId}

    $.ajax({
        type: "GET",
        async: false,
        url: "../scripts/check_email_unique.php",
        data: data,
        success: function(response) {
            isEmailValid = response === "true";
        },
        error: function(error) {
            console.error(error);
        }
    });

    return isEmailValid;
}, "Пользователь с таким email уже существует");

$.validator.addMethod("validAddress", function(value, element) {
    var isAddressValid = false;

    verifyAddress(value).done(function(response) {
        if (response.suggestions && response.suggestions.length > 0) {
            showSelected(response.suggestions[0]);
            isAddressValid = true;
        }
    }).fail(function(error) {
        console.error(error);
    });

    return isAddressValid;
}, "Введите корректный адрес.");

$(document).ready(function () {
    var fullAddress = $city.val() + ', ' + $street.val() + ', ' + $house.val() + ', ' + $flat.val();
    if(fullAddress != ", , , ") {
        $address.val(fullAddress);
        validateAddress();
    }

    $("#form").validate({
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            error.appendTo(element.parent());
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        rules: {
            fio: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true,
                uniqueEmail: true
            },
            phone: {
                required: true,
                phone: true,
            },
            address: {
                required: true
            },
            city: {
                required: true
            },
            street: {
                required: true
            },
            house: {
                required: true
            },
            login: {
                required: true,
                minlength: 3
            },
            password: {
                required: true
            }
        },
        messages: {
            fio: {
                required: "Введите ФИО",
                minlength: "ФИО должно содержать минимум 3 символа"
            },
            email: {
                required: "Введите email",
                email: "Введите корректный email"
            },
            phone: {
                required: "Введите номер телефона",
                pattern: "Введите корректный номер телефона (11 цифр)"
            },
            address: {
                required: "Введите полный адрес"
            },
            city: {
                required: "Введите город"
            },
            street: {
                required: "Введите улицу"
            },
            house: {
                required: "Введите номер дома"
            },
            login: {
                required: "Введите логин",
                minlength: "Логин должен содержать минимум 3 символа"
            },
            password: {
                required: "Введите пароль"
            }
        },
        submitHandler: function (form) {
            if(!isCapthcaDone) {
                alert("пройдите капчу");
                return;
            }
            form.submit();
        }});

});

function onCaptchaDone() {
    isCapthcaDone = true;
}

$city.change(function() {
    updateAddressString();
    validateAddress();
});

$street.change(function() {
    updateAddressString();
    validateAddress();
});

$house.change(function() {
    updateAddressString();
    validateAddress();
});

$flat.change(function() {
    updateAddressString();
    validateAddress();
});

function join(arr /*, separator */) {
    var separator = arguments.length > 1 ? arguments[1] : ", ";
    return arr.filter(function(n){return n}).join(separator);
}

function updateAddressString() {
    var city = $city.val();
    var street = $street.val();
    var house = $house.val();
    var flat = $flat.val();

    $address.val(join([city, street, house, flat], ", "));
}

function showCity(address) {
    $city.val(join([
        join([address.city_type, address.city], " "),
        join([address.settlement_type, address.settlement], " ")
    ]));
}

function showStreet(address) {
    $street.val(
        join([address.street_type, address.street], " ")
    );
}

function showHouse(address) {
    $house.val(join([
        join([address.house_type, address.house], " "),
        join([address.block_type, address.block], " ")
    ]));
}

function showFlat(address) {
    $flat.val(
        join([address.flat_type, address.flat], " ")
    );
}

function showSelected(suggestion) {
    var address = suggestion.data;
    showCity(address);
    showStreet(address);
    showHouse(address);
    showFlat(address);
}

$address.suggestions({
    token: token,
    type: type,
    hint: false,
    onSelect: showSelected
});

$city.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "city-settlement",
});

$street.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "street",
    constraints: $city,
});

$house.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "house",
    constraints: $street,
});

$flat.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "flat",
    constraints: $house,
});

function verifyAddress(address) {
    var serviceUrl = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address";
    var params = {
        type: "POST",
        contentType: "application/json",
        headers: {
            "Authorization": "Token " + token
        },
        data: JSON.stringify({
            query: address,
            count: 1
        })
    };
    return $.ajax(serviceUrl, params);
}

function validateAddress() {
    var fullAddress = $city.val() + ', ' + $street.val() + ', ' + $house.val() + ', ' + $flat.val();
    verifyAddress(fullAddress).done(function(response) {
        if (response.suggestions && response.suggestions.length > 0) {
            var suggestion = response.suggestions[0];
            $address.val(suggestion.value);
            showSelected(suggestion);
            return true;
        } else {
            return false;
        }
    });
}

</script>

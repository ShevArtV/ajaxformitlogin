<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$_modx->resource.pagetitle}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container py-5">
    <h1 class="text-center">Редактирование личных данных</h1>
    <div class="col-12 mx-auto">
        {'!AjaxFormitLogin' | snippet : [
        'form' =>  'aflLogoutForm',
        'snippet' => 'FormIt',
        'hooks' => 'AjaxIdentification',
        'method' => 'logout',
        'successMessage' => 'До новых встреч!',
        'redirectTo' => 1,
        'validationErrorMessage' => ''
        ]}
    </div>
    <div class="col-12 mx-auto">
        {'!AjaxFormitLogin' | snippet : [
        'form' =>  'aflUpdateProfileForm',
        'snippet' => 'FormIt',
        'hooks' => 'AjaxIdentification',
        'method' => 'update',
        'successMessage' => 'Данные сохранены.',
        'clearFieldsOnSuccess' => 0,

        'validate' => 'email:required:email',
        'validationErrorMessage' => 'Исправьте, пожалуйста, ошибки!',
        'email.vTextRequired' => 'Укажите email.'
        ]}
    </div>
    <div class="col-12 mx-auto">
        {'!AjaxFormitLogin' | snippet : [
        'form' => 'aflUpdatePassForm',
        'snippet' => 'FormIt',
        'hooks' => 'AjaxIdentification',
        'method' => 'update',
        'successMessage' => 'Пароль изменён.',

        'validate' => 'password:required:minLength=^8^:regexp=^/\A[\da-zA-Z!#\?&]*$/^,password_confirm:password_confirm=^password^',
        'validationErrorMessage' => 'Исправьте, пожалуйста, ошибки!',

        'password.vTextRequired' => 'Придумайте пароль.',
        'password.vTextRegexp' => 'Пароль может содержать только цифры, латинские буквы и символы !,#,?,&',
        'password.vTextMinLength' => 'Пароль должен быть не менее 8 символов.',
        ]}
    </div>
</div>
</body>
</html>
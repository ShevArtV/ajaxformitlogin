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
    <h1 class="text-center">Авторизация по Email</h1>
    {'!AjaxFormitLogin' | snippet : [
    'form' =>  'aflLoginForm',
    'snippet' => 'FormIt',
    'successMessage' => 'Вы успешно авторизованы и будете перенаправлены в личный кабинет.',
    'validate' => 'email:required,password:required',
    'validationErrorMessage' => 'Исправьте, пожалуйста, ошибки!',
    'hooks' => 'AjaxIdentification',

    'method' => 'login',

    'redirectTo' => 5,
    'redirectTimeout' => 3000,
    'usernameField' => 'email',
    'spamProtection' => 1,

    'email.vTextRequired' => 'Укажите email.',
    'password.vTextRequired' => 'Введите пароль.',
    'secret.vTextContains' => 'Кажется Вы робот. Если это не так, обновите страницу.'
    ]}
</div>
</body>
</html>
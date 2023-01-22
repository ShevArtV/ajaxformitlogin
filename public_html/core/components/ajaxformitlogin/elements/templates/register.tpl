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
    <h1 class="text-center">Регистрация по email</h1>

    {'!pdoMenu' | snippet:['parents' => 0]}

    {'!AjaxFormitLogin' | snippet : [
    'form' =>  'aflRegisterForm',
    'snippet' => 'FormIt',
    'hooks' => 'AjaxIdentification,FormItSaveForm,FormItAutoResponder',
    'method' => 'register',
    'successMessage' => 'Вы успешно зарегистрированы. Подтвердите email для активации учётной записи.',
    'customValidators' => 'aflUserExists,aflCheckPassLength,aflPasswordConfirm',
    'formName' => 'Регистрация по email',

    'fiarSubject' => 'Активация пользователя',
    'fiarFrom' => 'email@domain.ru',
    'fiarTpl' => 'aflActivateEmail',

    'activation' => 1,
    'autoLogin' => 0,
    'redirectId' => '',
    'authenticateContexts' => '',
    'passwordField' => '',
    'usernameField' => 'email',
    'usergroupsField' => '',
    'moderate' => '',
    'redirectTimeout' => 3000,
    'usergroups' => 2,
    'activationResourceId' => 1,
    'extendedFieldPrefix' => 'extended_',
    'activationUrlTime' => 10800,
    'validate' => 'email:required:aflUserExists,password:aflCheckPassLength=^8^,password_confirm:aflPasswordConfirm=^password^,politics:minValue=^1^',
    'validationErrorMessage' => 'Исправьте, пожалуйста, ошибки!',
    'spamProtection' => 1,

    'politics.vTextMinValue' => 'Примите наши условия.',
    'phone.vTextRequired' => 'Укажите телефон.',
    'password.vTextRequired' => 'Придумайте пароль.',
    'password.vTextMinLength' => 'Пароль должен быть не менее 8 символов.',
    'fullname.vTextRequired' => 'Укажите ФИО.',
    'fullname.vTextMinLength' => 'Слишком короткое ФИО.',
    'username.vTextAflUserExists' => 'Этот телефон уже используется. Укажите другой номер.',
    'secret.vTextContains' => 'Кажется Вы робот. Если это не так, обновите страницу.'
    ]}
</div>
</body>
</html>
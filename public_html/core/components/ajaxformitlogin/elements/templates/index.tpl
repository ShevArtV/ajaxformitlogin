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
    <h1 class="text-center">AjaxFormitLogin</h1>
    {set $user  = '!aflActivateUser' | snippet:[]}
    {if $user}
        <h2>Уважаемый, {$user.username}, Ваш аккаунт успешно активирован!</h2>
    {/if}

    {'!AjaxFormitLogin' | snippet : [
    'form' =>  'aflExampleForm',
    'snippet' => 'FormIt',
    'hooks' => 'FormItSaveForm,email',
    'emailTo' => 'shev.art.v@yandex.ru',
    'emailFrom' => 'noreply@art-sites.ru',
    'emailSubject' => 'Тестовая форма',
    'emailTpl' => 'aflExampleEmail',
    'successMessage' => 'Форма успешно отправлена! Менеджер свяжется с Вами в течение 5 минут.',
    'clearFieldsOnSuccess' => 1,
    'transmittedParams' => ["success" => 'ym_goal', "error" => 'aliases'],
    'aliases' => 'email==Email,phone==Телефон,name==Имя,politics==Правила сервиса',
    'showUploadProgress' => 1,
    'spamProtection' => 1,
    'ym_goal' => 'TEST_GOAL',

    'validate' => 'email:required:email,name:required:minLength=^3^,phone:required,politics:minValue=^1^',
    'validationErrorMessage' => 'Исправьте, пожалуйста, ошибки!',
    'email.vTextRequired' => 'Укажите email.',
    'fullname.vTextRequired' => 'Укажите ФИО.',
    'fullname.vTextMinLength' => 'Слишком короткое ФИО.',
    'secret.vTextContains' => 'Кажется Вы робот. Если это не так, обновите страницу.',
    'politics.vTextMinValue' => 'Примите наши условия.'
    ]}
</div>
</body>
</html>
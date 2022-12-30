<!doctype html>
<html lang="ru">
{include 'file:head.tpl'}
<body>
<div class="container py-5">
    <h1 class="text-center">AjaxFormitLogin</h1>
    {set $user  = '!ActivateUser' | snippet:[]}
    {if $user}
        <h2>Уважаемый, {$user.username}, Ваш аккаунт успешно активирован!</h2>
    {/if}

    {'!AjaxFormitLogin' | snippet : [
    'form' =>  'exampleForm',
    'snippet' => 'FormIt',
    'hooks' => 'FormItSaveForm,email',
    'emailTo' => 'shev.art.v@yandex.ru',
    'emailFrom' => 'noreply@modx3.art-sites.ru',
    'emailSubject' => 'Тестовая форма',
    'emailTpl' => 'exampleEmail',
    'successMessage' => 'Форма успешно отправлена! Менеджер свяжется с Вами в течение 5 минут.',
    'clearFieldsOnSuccess' => 1,
    'transmittedParams' => '{ "success":"test1,test2", "error": "test3"}',
    'test1' => 'It is test params One',
    'test2' => 123,
    'test3' => 'is error',
    'showUploadProgress' => 1,
    'spamProtection' => 1,

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
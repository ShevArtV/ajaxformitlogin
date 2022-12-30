<!doctype html>
<html lang="ru">
{include 'file:head.tpl'}
<body>
<div class="container py-5">
    <h1 class="text-center">Авторизация по Email</h1>
    {'!AjaxFormitLogin' | snippet : [
    'form' =>  'loginForm',
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
<!doctype html>
<html lang="ru">
{include 'file:head.tpl'}
<body>
<div class="container py-5">
    <h1 class="text-center">Сброс пароля</h1>
    {'!AjaxFormitLogin' | snippet : [
    'form' =>  'forgotForm',
    'snippet' => 'FormIt',
    'hooks' => 'AjaxIdentification,FormItSaveForm,FormItAutoResponder',
    'method' => 'forgot',
    'successMessage' => 'Новый пароль отправлен на ваш email',
    'customValidators' => 'userNotExists',
    'formName' => 'Забыли пароль',
    'spamProtection' => 1,

    'usernameField' => 'email',
    'validate' => 'email:required:userNotExists',
    'validationErrorMessage' => 'Исправьте, пожалуйста, ошибки!',

    'fiarSubject' => 'Восстановление пароля',
    'fiarFrom' => 'email@domain.ru',
    'fiarTpl' => 'resetPassEmail',

    'email.vTextRequired' => 'Укажите email.',
    'email.vTextUserNotExists' => 'Пользователь не найден',
    'secret.vTextContains' => 'Кажется Вы робот. Если это не так, обновите страницу.'
    ]}
</div>
</body>
</html>
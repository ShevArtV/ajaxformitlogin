<!doctype html>
<html lang="ru">
{include 'file:head.tpl'}
<body>
<div class="container py-5">
    <h1 class="text-center">Регистрация по email</h1>

    {'!pdoMenu' | snippet:['parents' => 0]}

    {'!AjaxFormitLogin' | snippet : [
    'form' =>  '@FILE chunks/forms/registerForm.tpl',
    'snippet' => 'FormIt',
    'hooks' => 'AjaxIdentification,FormItSaveForm,FormItAutoResponder',
    'method' => 'register',
    'successMessage' => 'Вы успешно зарегистрированы. Подтвердите email для активации учётной записи.',
    'customValidators' => 'checkPassLength,passwordConfirm',
    'formName' => 'Регистрация по email',

    'fiarSubject' => 'Активация пользователя',
    'fiarFrom' => 'email@domain.ru',
    'fiarTpl' => '@FILE chunks/emails/activateEmail.tpl',

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
    'validationErrorMessage' => 'Исправьте, пожалуйста, ошибки!',
    'spamProtection' => 1,
    'validate' => 'email:required,password:checkPassLength=^8^,password_confirm:passwordConfirm=^password^,politics:minValue=^1^',
    'politics.vTextMinValue' => 'Примите наши условия.',
    'phone.vTextRequired' => 'Укажите телефон.',
    'password.vTextRequired' => 'Придумайте пароль.',
    'password.vTextMinLength' => 'Пароль должен быть не менее 8 символов.',
    'fullname.vTextRequired' => 'Укажите ФИО.',
    'fullname.vTextMinLength' => 'Слишком короткое ФИО.',
    'secret.vTextContains' => 'Кажется Вы робот. Если это не так, обновите страницу.'
    ]}
</div>
</body>
</html>
<!-- 'validate' => 'email:required:userExists1,password:checkPassLength=^8^,password_confirm:passwordConfirm=^password^,politics:minValue=^1^', -->
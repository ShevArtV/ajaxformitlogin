<!doctype html>
<html lang="ru">
{include 'file:head.tpl'}
<body>
<div class="container py-5">
    <h1 class="text-center">Редактирование личных данных</h1>
    <div class="col-12 mx-auto">
        {'!AjaxFormitLogin' | snippet : [
        'form' =>  'logoutForm',
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
        'form' =>  'updateProfileForm',
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
        'form' => 'updatePassForm',
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
<?php

return [
    'AjaxFormitLogin' => [
        'file' => 'snippet.ajaxformitlogin',
        'description' => 'сниппет вывода формы, аналог AjaxForm',
        'properties' => [],
    ],

    'ActivateUser' => [
        'file' => 'snippet.activateuser',
        'description' => 'сниппет активации пользователя',
        'properties' => [],
    ],
    'AjaxIdentification' => [
        'file' => 'hooks/hook.ajaxidentification',
        'description' => 'хук для FormIt, позволяющий использовать регистрацию/авторизацию черех AJAX',
        'properties' => [],
    ],
    'checkPassLength' => [
        'file' => 'validators/validator.checkpasslength',
        'description' => 'валидатор проверки длины пароля, позволяет генерировать пароль на сервере',
        'properties' => [],
    ],
    'passwordConfirm' => [
        'file' => 'validators/validator.passwordconfirm',
        'description' => 'валидатор подтверждения пароля, позволяет генерировать пароль на сервере',
        'properties' => [],
    ],
    'requiredIf' => [
        'file' => 'validators/validator.requiredif',
        'description' => 'валидатор обязательности ввода по условию',
        'properties' => [],
    ],
    'userExists' => [
        'file' => 'validators/validator.userexists',
        'description' => 'валидатор существования пользователя',
        'properties' => [],
    ],
    'userNotExists' => [
        'file' => 'validators/validator.usernotexists',
        'description' => 'валидатор отсутствия пользователя',
        'properties' => [],
    ],
];
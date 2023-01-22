<?php

return [
    'AjaxFormitLogin' => [
        'file' => 'snippet.ajaxformitlogin',
        'description' => 'сниппет вывода формы, аналог AjaxForm',
        'properties' => [
            'form' => [
                'type' => 'textfield',
                'value' => 'aflExampleForm',
            ],
            'snippet' => [
                'type' => 'textfield',
                'value' => 'FormIt',
            ],
            'hooks' => [
                'type' => 'textfield',
                'value' => 'FormItSaveForm,email',
            ],
            'emailTo' => [
                'type' => 'textfield',
                'value' => '',
            ],
            'emailFrom' => [
                'type' => 'textfield',
                'value' => '',
            ],
            'emailSubject' => [
                'type' => 'textfield',
                'value' => '',
            ],
            'emailTpl' => [
                'type' => 'textfield',
                'value' => 'aflExampleEmail',
            ],
            'successMessage' => [
                'type' => 'textfield',
                'value' => 'Форма успешно отправлена! Менеджер свяжется с Вами в течение 5 минут.',
            ],
            'clearFieldsOnSuccess' => [
                'type' => 'combo-boolean',
                'value' => true,
            ],
            'transmittedParams' => [
                'type' => 'textfield',
                'value' => '["success" => "", "error" => "aliases"]',
            ],
            'aliases' => [
                'type' => 'textfield',
                'value' => 'email==Email',
            ],
            'validate' => [
                'type' => 'textfield',
                'value' => 'email:required:email',
            ],
            'showUploadProgress' => [
                'type' => 'combo-boolean',
                'value' => true,
            ],
            'spamProtection' => [
                'type' => 'combo-boolean',
                'value' => true,
            ],
            'redirectTimeout' => [
                'type' => 'textfield',
                'value' => 2000,
            ],
            'redirectTo' => [
                'type' => 'textfield',
                'value' => '',
            ],
        ],
    ],

    'aflActivateUser' => [
        'file' => 'snippet.activateuser',
        'description' => 'сниппет активации пользователя',
        'properties' => [],
    ],
    'AjaxIdentification' => [
        'file' => 'hooks/hook.ajaxidentification',
        'description' => 'хук для FormIt, позволяющий использовать регистрацию/авторизацию черех AJAX',
        'properties' => [],
    ],
    'aflCheckPassLength' => [
        'file' => 'validators/validator.checkpasslength',
        'description' => 'валидатор проверки длины пароля, позволяет генерировать пароль на сервере',
        'properties' => [],
    ],
    'aflPasswordConfirm' => [
        'file' => 'validators/validator.passwordconfirm',
        'description' => 'валидатор подтверждения пароля, позволяет генерировать пароль на сервере',
        'properties' => [],
    ],
    'aflRequiredIf' => [
        'file' => 'validators/validator.requiredif',
        'description' => 'валидатор обязательности ввода по условию',
        'properties' => [],
    ],
    'aflUserExists' => [
        'file' => 'validators/validator.userexists',
        'description' => 'валидатор существования пользователя',
        'properties' => [],
    ],
    'aflUserNotExists' => [
        'file' => 'validators/validator.usernotexists',
        'description' => 'валидатор отсутствия пользователя',
        'properties' => [],
    ],
];
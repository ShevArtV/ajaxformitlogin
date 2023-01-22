<?php

return [
    'frontend_js' => [
        'xtype' => 'textfield',
        'value' => '[[+assetsUrl]]js/default.js',
        'area' => 'default',
    ],
    'notify_classname' => [
        'xtype' => 'textfield',
        'value' => 'AflIziToast',
        'area' => 'default',
    ],
    'notify_classpath' => [
        'xtype' => 'textfield',
        'value' => './aflizitoast.class.js',
        'area' => 'default',
    ],
    'notify_js' => [
        'xtype' => 'textfield',
        'value' => 'assets/components/ajaxformitlogin/js/message_settings.json',
        'area' => 'default',
    ],
    'metrics' => [
        'xtype' => 'combo-boolean',
        'value' => '',
        'area' => 'default',
    ],
    'counter_id' => [
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'default',
    ]
];
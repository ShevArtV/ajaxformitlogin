<?php

return [
    'afl_frontend_js' => [
        'xtype' => 'textfield',
        'value' => '[[+assetsUrl]]js/default.js',
        'area' => 'ajaxformitlogin_main',
    ],
    'afl_notify_classname' => [
        'xtype' => 'textfield',
        'value' => 'AflIziToast',
        'area' => 'ajaxformitlogin_main',
    ],
    'afl_notify_classpath' => [
        'xtype' => 'textfield',
        'value' => './aflizitoast.class.js',
        'area' => 'ajaxformitlogin_main',
    ],
    'afl_notify_js' => [
        'xtype' => 'textfield',
        'value' => 'assets/components/ajaxformitlogin/js/message_settings.json',
        'area' => 'ajaxformitlogin_main',
    ],
];
<?php
// php7.4 public_html/_build/build.php
if (!defined('MODX_CORE_PATH')) {
    $path = dirname(__FILE__);
    while (!file_exists($path . '/core/config/config.inc.php') && (strlen($path) > 1)) {
        $path = dirname($path);
    }
    define('MODX_CORE_PATH', $path . '/core/');
}

return [
    'name' => 'AjaxFormitLogin',
    'name_lower' => 'ajaxformitlogin',
    'version' => '1.0.1',
    'release' => 'pl',
    // Install package to site right after build
    'install' => false,
    // Which elements should be updated on package upgrade
    'update' => [
        'chunks' => true,
        'menus' => false,
        'permission' => false,
        'plugins' => false,
        'policies' => false,
        'policy_templates' => false,
        'resources' => false,
        'settings' => true,
        'snippets' => true,
        'templates' => false,
        'widgets' => false,
    ],
    // Which elements should be static by default
    'static' => [
        'plugins' => false,
        'snippets' => true,
        'chunks' => true,
    ],
    // Log settings
    'log_level' => !empty($_REQUEST['download']) ? 0 : 3,
    'log_target' => php_sapi_name() == 'cli' ? 'ECHO' : 'HTML',
    // Download transport.zip after build
    'download' => !empty($_REQUEST['download']),
];
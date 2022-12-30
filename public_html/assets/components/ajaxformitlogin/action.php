<?php
/** @var modX $modx */
define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';
$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');

// Switch context if need
if (!empty($_REQUEST['pageId'])) {
    if ($resource = $modx->getObject('modResource', (int)$_REQUEST['pageId'])) {
        if ($resource->get('context_key') != 'web') {
            $modx->switchContext($resource->get('context_key'));
        }
        $modx->resource = $resource;
    }
}

/** @var AjaxFormitLogin $AjaxFormitLogin */
$AjaxFormitLogin = $modx->getService('ajaxformitlogin', 'AjaxFormitLogin', $modx->getOption('afl_core_path', null,
        $modx->getOption('core_path') . 'components/ajaxformitlogin/') . 'model/ajaxformitlogin/', array());

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    $modx->sendRedirect($modx->makeUrl($modx->getOption('site_start'), '', '', 'full'));
} elseif (empty($_REQUEST['afl_action'])) {
    echo $AjaxFormitLogin->error('afl_err_action_ns');
} else {
    echo $AjaxFormitLogin->process($_REQUEST['afl_action'], array_merge($_FILES, $_REQUEST));
}

@session_write_close();
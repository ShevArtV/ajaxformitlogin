<?php
/** @var array $scriptProperties */
/** @var AjaxFormitLogin $AjaxFormitLogin */
if (!$modx->loadClass('ajaxformitlogin', MODX_CORE_PATH . 'components/ajaxformitlogin/model/ajaxformitlogin/', false, true)) {
    return false;
}
if(!function_exists('generateRandString')){
    function generateRandString($modx, $length = 0)
    {
        if (!$length) {
            $length = $modx->getOption('password_min_length', '', 8);
        }

        $string = '';
        $arr = array(
            'a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'q', 'r',
            's', 't', 'u', 'v', 'w', 'x',
            'y', 'z', 'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H', 'I', 'J',
            'K', 'L', 'M', 'N', 'O', 'P',
            'Q', 'R', 'S', 'T', 'U', 'V',
            'W', 'X', 'Y', 'Z', '@', '%',
            '#', '!', "&"
        );

        for ($i = 0; $i < $length; $i++) {
            $string .= $arr[mt_rand(0, count($arr) - 1)];
        }

        return $string;
    }
}


$scriptProperties['secret'] = generateRandString($modx);
$AjaxFormitLogin = new AjaxFormitLogin($modx, $scriptProperties);
$config = $AjaxFormitLogin->config;
$config['pageId'] = $modx->resource->id;
$frontConfigFields = [
    'formSelector',
    'showUploadProgress',
    'fileUplodedProgressMsg',
    'fileUplodedSuccessMsg',
    'fileUplodedErrorMsg',
    'ajaxErrorMsg',
    'message_handler',
    'message_handler_method',
    'clearFieldsOnSuccess',
    'pageId',
    'notifySettingsPath',
    'notifyClassName',
    'notifyClassPath',
    'spamProtection'
];

$assetsUrl = $modx->getOption('ajaxformitlogin_assets_url', $config, $modx->getOption('assets_url') . 'components/ajaxformitlogin/');
$parsedConfig = str_replace('[[+assetsUrl]]',$assetsUrl, $config);
$snippet = $modx->getOption('snippet', $config, 'FormIt', true);
$tpl = $modx->getOption('form', $config, 'tpl.AjaxForm.example', true);
$formSelector = $modx->getOption('formSelector', $config, 'afl_form', true);
$objectName = $modx->getOption('objectName', $config, 'AjaxFormitLogin', true);
$frontendConfig = array();
foreach($parsedConfig as $k => $v){
    if(in_array($k, $frontConfigFields)){
        $frontendConfig[$k] = $v;
    }
}

/** @var pdoTools $pdo */
if (class_exists('pdoTools') && $pdo = $modx->getService('pdoTools')) {
    $content = $pdo->parseChunk($tpl, $config);
} else {
    $content = $modx->parseChunk($tpl, $config);
}
if (empty($content)) {
    return $modx->lexicon('afl_err_chunk_nf', array('name' => $tpl));
}

// Add selector to tag form
if (preg_match('#<form.*?class=(?:"|\')(.*?)(?:"|\')#i', $content, $matches)) {
    $classes = explode(' ', $matches[1]);

    if (!in_array('afl_form', $classes)) {
        $classes[] = 'afl_form';
    }
    if (!in_array($formSelector, $classes)) {
        $classes[] = $formSelector;
    }
    $classes = preg_replace(
        '#class=(?:"|\')' . $matches[1] . '(?:"|\')#i',
        'class="' . implode(' ', $classes) . '"',
        $matches[0]
    );
    $content = str_ireplace($matches[0], $classes, $content);

} else {
    $content = str_ireplace('<form', '<form class="afl_form ' . $formSelector . '"', $content);
}

// Add method = post
if (preg_match('#<form.*?method=(?:"|\')(.*?)(?:"|\')#i', $content)) {
    $content = preg_replace('#<form(.*?)method=(?:"|\')(.*?)(?:"|\')#i', '<form\\1method="post"', $content);
} else {
    $content = str_ireplace('<form', '<form method="post"', $content);
}

// Add action for form processing
$hash = md5(http_build_query($config));
$action = '<input type="hidden" name="afl_action" value="' . $hash . '" />';
$secret = '<input type="text" name="secret" data-secret="'.$scriptProperties['secret'].'" style="position: absolute;opacity:0;z-index: -1;width:0;" autocomplete="off">';
$inputConfig = '<input type="hidden" name="afl_config" value=\'' . str_replace('{', '{ ',json_encode($frontendConfig)) . '\' />';

if ((stripos($content, '</form>') !== false)) {
    if (preg_match('#<input.*?name=(?:"|\')afl_action(?:"|\').*?>#i', $content, $matches)) {
        $content = str_ireplace($matches[0], '', $content);
    }
    if (preg_match('#<input.*?name=(?:"|\')afl_config(?:"|\').*?>#i', $content, $matches)) {
        $content = str_ireplace($matches[0], '', $content);
    }
    $content = str_ireplace('</form>', "\n\t$action\n</form>", $content);
    $content = str_ireplace('</form>', "\n\t$inputConfig\n</form>", $content);
    $content = str_ireplace('</form>', "\n\t$secret\n</form>", $content);
}

// Save settings to user`s session
$_SESSION['AjaxFormitLogin'][$hash] = $config;

// Call snippet for preparation of form
$action = !empty($_REQUEST['afl_action'])
    ? $_REQUEST['afl_action']
    : $hash;

$AjaxFormitLogin->loadJsCss($objectName);

if($_POST['afl_action']){
    $AjaxFormitLogin->process($action, $_REQUEST);
}

// Return chunk
return $content;
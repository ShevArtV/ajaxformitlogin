<?php
require_once MODX_CORE_PATH . 'components/ajaxformitlogin/model/ajaxformitlogin/ajaxidentification.class.php';
if($scriptProperties['method']){
    $method = $scriptProperties['method'];
    $ajaxident = new AjaxIdentification($modx,$hook,$scriptProperties);
    return $ajaxident->$method();
}
return true;
<?php
if($modx->getCount('modUser', array('username' => $value))){
    $msg = $scriptProperties[$key.'.vTextUserExists'] ?: 'Пользователь с такими данными уже существует';
    $validator->addError($key, $msg);
}
return true;
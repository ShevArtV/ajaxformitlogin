<?php
if ($_GET['lu']) {
    require_once MODX_CORE_PATH . 'components/ajaxformitlogin/model/ajaxformitlogin/ajaxidentification.class.php';
    $username = AjaxIdentification::base64url_decode($_GET['lu']);
    if ($user = $modx->getObject('modUser', array('username' => $username))) {
        $profile = $user->getOne('Profile');
        $extended = $profile->get('extended');
        if ($user->get('active')) {
            return array_merge($profile->toArray(), $user->toArray());
        }
        if ($extended['activate_before'] - time() > 0) {
            $user->set('active', 1);
            $user->save();
            unset($extended['activate_before']);
            $profile->set('extended', $extended);
            $profile->save();
            return array_merge($profile->toArray(), $user->toArray());
        } else {
            $user->remove();
        }
    }
}
return false;
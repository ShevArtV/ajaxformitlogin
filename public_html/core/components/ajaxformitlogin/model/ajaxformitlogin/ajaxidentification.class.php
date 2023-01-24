<?php

class AjaxIdentification
{

    /**
     * @param modX $modx A reference to the Modx instance
     * @param array $config
     * @param object $hook
     */
    function __construct(modX $modx, object $hook, array $config = array())
    {
        $this->modx = $modx;
        $this->config = $config;
        $this->hook = $hook;
    }


    /**
     * @return mixed
     */
    public function register()
    {
        $email = $_POST['email'];
        $passwordField = $this->config['passwordField'] ?: 'password';
        $usernameField = $this->config['usernameField'] ?: 'username';
        $activation = $this->config['activation'];
        $moderate = $this->config['moderate'];
        $activationResourceId = $this->config['activationResourceId'] ?: 1;
        $userGroupsField = $this->config['usergroupsField'] ?: '';
        $this->modx->user = $this->modx->getObject('modUser', 1);
        $userGroups = !empty($userGroupsField) && array_key_exists($userGroupsField, $_POST) ? $_POST[$userGroupsField] : explode(',', $this->config['usergroups']);
        if ($userGroups) {
            foreach ($userGroups as $k => $group) {
                $group = explode(':', $group);
                $_POST['groups'][] = array(
                    'usergroup' => $group[0],
                    'role' => $group[1] ?: 1,
                    'rank' => $group[2] ?: $k,
                );
            }
        }
        if (!$_POST[$passwordField]) {
            $_POST[$passwordField] = $this->generateCode('pass', 10);
        }
        $_POST['passwordgenmethod'] = 'none';
        $_POST['specifiedpassword'] = $_POST[$passwordField];
        $this->hook->setValue('password', $_POST[$passwordField]);
        $this->hook->setValue('username', $_POST[$usernameField]);
        $_POST['confirmpassword'] = $_POST[$passwordField];
        $_POST['username'] = $_POST[$usernameField];
        $_POST['passwordnotifymethod'] = 's';

        if (!$activation) {
            $_POST['active'] = 1;
        }

        if ($moderate) {
            $_POST['blocked'] = 1;
        }

        $_POST['extended'] = $this->prepareExtended();
        $response = $this->modx->runProcessor('/security/user/create', $_POST);
        if ($response->isError()) {
            $errors = $response->response['errors'];
            $errorMsg = array();
            foreach ($errors as $error) {
                $errorMsg[] = $errors[0]['msg'];
            }
            $this->hook->addError('secret', implode('. ', $errorMsg));
            $this->hook->hasErrors();
            $this->modx->user = null;
            return false;
        }

        $this->modx->user = $this->modx->getObject('modUser', $response->response['object']['id']);

        /* получаем ссылку для подтверждения почты */
        if ($activation && !empty($email) && !empty($activationResourceId)) {
            $confirmUrl = $this->getConfirmUrl($activationResourceId);
            $this->hook->setValue('confirmUrl', $confirmUrl);
        }

        if ($this->config['autoLogin'] == true && !$activation && !$moderate) {
            $this->login();
        }
        return true;
    }

    public function login()
    {
        $contexts = $this->config['authenticateContexts'];
        $passwordField = $this->config['passwordField'] ?: 'password';
        $usernameField = $this->config['usernameField'] ?: 'username';

        if (!$_POST[$usernameField] || !$_POST[$passwordField]) {
            return false;
        }

        $c = array(
            'login_context' => $this->modx->context->key,
            'add_contexts' => $contexts,
            'username' => $_POST[$usernameField],
            'password' => $_POST[$passwordField],
            'rememberme' => $_POST['rememberme'],
        );

        $response = $this->modx->runProcessor('/security/login', $c);

        if ($response->isError()) {
            $this->hook->addError('secret', $response->getMessage());
            $this->hook->hasErrors();
        }
        return true;
    }

    public function update()
    {
        if ((int)$_POST['uid']) {
            $user = $this->modx->getObject('modUser', (int)$_POST['uid']);
        } else {
            $user = $this->modx->user;
        }

        if ($this->modx->user->isAuthenticated($this->modx->context->get('key'))) {
            $profile = $user->getOne('Profile');
            $profileData = $profile->toArray();
            $extended = $this->prepareExtended() ?: array();
            $_POST['extended'] = array_merge($profileData['extended'], $extended);
            $_POST['dob'] = $_POST['dob'] ? strtotime($_POST['dob']) : $profile->get('dob');
            $userData = $user->toArray();
            unset($userData['password']);
            unset($userData['cachepwd']);

            $user->fromArray(array_merge($userData, $_POST));
            $profile->fromArray(array_merge($profileData, $_POST));
            $user->save();
            $profile->save();

            $this->modx->invokeEvent('aiOnUserUpdate', array(
                'user' => $user,
                'profile' => $profile,
                'data' => $_POST
            ));

        }
        return true;
    }

    public function logout()
    {
        $contexts = $this->config['authenticateContexts'];
        $response = $this->modx->runProcessor('/security/logout', array(
            'login_context' => $this->modx->context->key,
            'add_contexts' => $contexts
        ));

        if ($response->isError()) {
            $this->hook->addError('secret', $response->getMessage());
            $this->hook->hasErrors();
        }
        return true;
    }

    public function forgot()
    {
        $usernameField = $this->config['usernameField'] ?: 'username';
        $user = $this->modx->getObject('modUser', array('username' => $_POST[$usernameField]));

        if (is_object($user)) {
            if (!$_POST['password']) {
                $_POST['password'] = $this->generateCode();
                $this->hook->setValue('password', $_POST['password']);
            }

            $user->set('password', $_POST['password']);
            $user->save();

            if ($this->config['autoLogin'] == true && $user->get('active') && !$user->get('block')) {
                $this->login();
            }
        }
        return true;
    }

    /**
     * @param string $type
     * @param integer $length
     *
     * @return string
     */
    public function generateCode($type = 'pass', $length = 0)
    {
        if (!$length) {
            $length = $this->modx->getOption('password_min_length');
        }

        $password = "";
        /* Массив со всеми возможными символами в пароле */
        switch ($type) {
            case 'pass':
                $arr = array(
                    'a', 'b', 'c', 'd', 'e', 'f',
                    'g', 'h', 'i', 'j', 'k', 'l',
                    'm', 'n', 'o', 'p', 'q', 'r',
                    's', 't', 'u', 'v', 'w', 'x',
                    'y', 'z', 'A', 'B', 'C', 'D',
                    'E', 'F', 'G', 'H', 'I', 'J',
                    'K', 'L', 'M', 'N', 'O', 'P',
                    'Q', 'R', 'S', 'T', 'U', 'V',
                    'W', 'X', 'Y', 'Z', '1', '2',
                    '3', '4', '5', '6', '7', '8',
                    '9', '0', '#', '!', "?", "&"
                );
                break;
            case 'hash':
                $arr = array(
                    'a', 'b', 'c', 'd', 'e', 'f',
                    'g', 'h', 'i', 'j', 'k', 'l',
                    'm', 'n', 'o', 'p', 'q', 'r',
                    's', 't', 'u', 'v', 'w', 'x',
                    'y', 'z', 'A', 'B', 'C', 'D',
                    'E', 'F', 'G', 'H', 'I', 'J',
                    'K', 'L', 'M', 'N', 'O', 'P',
                    'Q', 'R', 'S', 'T', 'U', 'V',
                    'W', 'X', 'Y', 'Z', '1', '2',
                    '3', '4', '5', '6', '7', '8',
                    '9', '0'
                );
                break;
            case 'code':
                $arr = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
                break;
        }

        for ($i = 0; $i < $length; $i++) {
            $password .= $arr[mt_rand(0, count($arr) - 1)]; // Берём случайный элемент из массива
        }

        return $password;
    }

    public function prepareExtended()
    {
        $extended = array();
        $extendedFieldPrefix = $this->config['extendedFieldPrefix'] ?: 'extended_';

        foreach ($_POST as $k => $v) {
            if (strpos($k, $extendedFieldPrefix) !== false) {
                $extended[str_replace($extendedFieldPrefix, '', $k)] = $v;
            }
        }
        return $extended;
    }

    /**
     * @param integer $activationResourceId
     *
     * @return string
     */
    public function getConfirmUrl($activationResourceId)
    {
        $confirmParams['lu'] = $this->base64url_encode($this->modx->user->get('username'));
        $profile = $this->modx->user->getOne('Profile');
        $extended = $profile->get('extended');
        $extended['activate_before'] = time() + $this->config['activationUrlTime'] ?: time() + 60 * 60 * 3; // срок жизни ссылки на активацию
        $profile->set('extended', $extended);
        $profile->save();
        return $this->modx->makeUrl($activationResourceId, '', $confirmParams, 'full');
    }

    /**
     * Encodes a string for URL safe transmission
     *
     * @access public
     * @param string $str
     * @return string
     */
    public function base64url_encode($str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    /**
     * Decodes an URL safe encoded string
     *
     * @access public
     * @param string $str
     * @return string
     */
    public static function base64url_decode($str)
    {
        return base64_decode(str_pad(strtr($str, '-_', '+/'), strlen($str) % 4, '=', STR_PAD_RIGHT));
    }


    public function activateUser($str)
    {
        $username = $this->base64url_decode($_GET['lu']);
        $userData = false;
        if ($user = $this->modx->getObject('modUser', array('username' => $username))) {
            $profile = $user->getOne('Profile');
            $extended = $profile->get('extended');

            if (!$user->get('active') && $extended['activate_before'] - time() <= 0) {
                $user->remove();
                return $userData;
            }

            $userData = array_merge($profile->toArray(), $user->toArray());

            if ($extended['activate_before'] - time() > 0) {
                $user->set('active', 1);
                $user->save();
                unset($extended['activate_before']);
                $profile->set('extended', $extended);
                $profile->save();
            }

            $this->modx->invokeEvent('OnUserActivate', array(
                'user' => $user,
                'profile' => $profile,
                'data' => $userData
            ));
            return $userData;
        }
    }
}
<?php

class AjaxFormitLogin
{
    /** @var modX $modx */
    public $modx;
    /** @var array $config */
    public $config;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('core_path') . 'components/ajaxformitlogin/';
        $assetsUrl = $this->modx->getOption('assets_url') . 'components/ajaxformitlogin/';

        $this->modx->lexicon->load('ajaxformitlogin:default');


        $this->config = array_merge(array(
            'corePath' => $corePath,
            'assetsUrl' => $assetsUrl,
            'actionUrl' => $assetsUrl . 'action.php',

            'formSelector' => 'afl_form',
            'json_response' => true,

            'fileUplodedProgressMsg' => $this->modx->lexicon('afl_message_uploded_progress'),
            'fileUplodedSuccessMsg' => $this->modx->lexicon('afl_message_uploded_success'),
            'fileUplodedErrorMsg' => $this->modx->lexicon('afl_message_uploded_error'),
            'ajaxErrorMsg' => $this->modx->lexicon('afl_message_ajax_error'),



            'notifySettingsPath' => $this->modx->getOption('afl_notify_js', '', 'assets/components/ajaxformitlogin/js/message_settings.json'),
            'frontend_js' => $this->modx->getOption('afl_frontend_js', '', '[[+assetsUrl]]js/default.js'),
            'notifyClassPath' => $this->modx->getOption('afl_notify_classpath', '', './aflizitoast.class.js'),
            'notifyClassName' => $this->modx->getOption('afl_notify_classname', '', 'AflIziToast'),
        ), $config);

        $this->config['formSelector'] = $this->config['formSelector'] . '_' . rand();
    }


    /**
     * Initializes AjaxForm into different contexts.
     *
     * @return boolean
     * @deprecated
     *
     */
    public function initialize()
    {
        $this->loadJsCss();

        return true;
    }


    /**
     * Independent registration of css and js
     *
     * @param string $objectName Name of object to initialize in javascript
     */
    public function loadJsCss($objectName = 'AjaxFormitLogin')
    {
        if ($js = trim($this->config['frontend_js'])) {
            if (preg_match('/\.js/i', $js)) {
                $scriptPath = str_replace('[[+assetsUrl]]', $this->config['assetsUrl'], $js);
                $this->modx->regClientScript(
                    '<script type="module" src="' . $scriptPath . '"></script>', true
                );
            }
        }
    }


    /**
     * Loads snippet for form processing
     *
     * @param $action
     * @param array $fields
     *
     * @return array|string
     */
    public function process($action, array $fields = array())
    {
        if (!isset($_SESSION['AjaxFormitLogin'][$action])) {
            return $this->error('afl_err_action_nf');
        }
        unset($fields['afl_action'], $_POST['afl_action'], $fields['afl_config']);

        $scriptProperties = $_SESSION['AjaxFormitLogin'][$action];
        $scriptProperties['fields'] = $fields;
        $scriptProperties['AjaxFormitLogin'] = $this;

        $name = $scriptProperties['snippet'] ?: 'FormIt';
        $set = '';
        if (strpos($name, '@') !== false) {
            list($name, $set) = explode('@', $name);
        }

        /** @var modSnippet $snippet */
        if ($snippet = $this->modx->getObject('modSnippet', array('name' => $name))) {
            $properties = $snippet->getProperties();
            $property_set = !empty($set)
                ? $snippet->getPropertySet($set)
                : array();

            $scriptProperties = array_merge($properties, $property_set, $scriptProperties);
            if ($scriptProperties['spamProtection']) {
                if ($scriptProperties['validate']) {
                    $scriptProperties['validate'] .= ',secret:contains=^' . $scriptProperties['secret'] . '^';
                } else {
                    $scriptProperties['validate'] .= 'secret:contains=^' . $scriptProperties['secret'] . '^';
                }
            }
            $snippet->_cacheable = false;
            $snippet->_processed = false;

            $response = $snippet->process($scriptProperties);
            if (strtolower($snippet->name) == 'formit') {
                $response = $this->handleFormIt($scriptProperties);

            }
            return $response;
        } else {
            return $this->error('afl_err_snippet_nf', array(), array('name' => $name));
        }
    }


    /**
     * Method for obtaining data from FormIt
     *
     * @param array $scriptProperties
     *
     * @return array|string
     */
    public function handleFormIt(array $scriptProperties = array())
    {
        $plPrefix = $scriptProperties['placeholderPrefix'] ?? 'fi.';
        $data = array();

        foreach ($scriptProperties['fields'] as $k => $v) {
            if (isset($this->modx->placeholders[$plPrefix . 'error.' . $k])) {
                $data['errors'][$k] = strip_tags($this->modx->placeholders[$plPrefix . 'error.' . $k]);
            }
        }
        if (isset($scriptProperties['transmittedParams'])) {
            $transmitted = json_decode($scriptProperties['transmittedParams'], 1);
        }

        if (!empty($data['errors'])) {
            $message = $scriptProperties['validationErrorMessage'] ?? 'afl_err_has_errors';
            $status = 'error';
            if (isset($transmitted['error'])) {
                $keys = explode(',', $transmitted['error']);
                foreach ($keys as $key) {
                    $data[$key] = $scriptProperties[$key];
                }
            }
        } else {
            $message = $scriptProperties['successMessage'] ?? 'afl_success_submit';
            $status = 'success';
            if (isset($transmitted['success'])) {
                $keys = explode(',', $transmitted['success']);
                foreach ($keys as $key) {
                    $data[$key] = $scriptProperties[$key];
                }
            }
            $data['redirectTimeout'] = $scriptProperties['redirectTimeout'] ?: 2000;
            $data['redirectUrl'] = $scriptProperties['redirectTo'];
            if ((int)$scriptProperties['redirectTo']) {
                $redirectUrl = $this->modx->makeUrl($scriptProperties['redirectTo'], '', '', 'full');
                $data['redirectUrl'] = $redirectUrl;
            }
        }

        return $this->$status($message, $data);
    }


    /**
     * This method returns an error of the order
     *
     * @param string $message A lexicon key for error message
     * @param array $data .Additional data, for example cart status
     * @param array $placeholders Array with placeholders for lexicon entry
     *
     * @return array|string $response
     */
    public function error($message = '', $data = array(), $placeholders = array())
    {
        $response = array(
            'success' => false,
            'message' => $this->modx->lexicon($message, $placeholders),
            'data' => $data,
        );

        return $this->modx->toJSON($response);
    }


    /**
     * This method returns an success of the order
     *
     * @param string $message A lexicon key for success message
     * @param array $data .Additional data, for example cart status
     * @param array $placeholders Array with placeholders for lexicon entry
     *
     * @return array|string $response
     */
    public function success($message = '', $data = array(), $placeholders = array())
    {
        $response = array(
            'success' => true,
            'message' => $this->modx->lexicon($message, $placeholders),
            'data' => $data,
        );

        return $this->modx->toJSON($response);
    }
}
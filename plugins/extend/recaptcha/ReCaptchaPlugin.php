<?php

namespace SunlightExtend\Recaptcha;

use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod\SocketPost;
use Sunlight\Extend;
use Sunlight\Plugin\ExtendPlugin;
use Sunlight\Plugin\PluginManager;

/**
 * ReCaptcha plugin
 *
 * @author Jirka Daněk <jdanek.eu>
 */
class ReCaptchaPlugin extends ExtendPlugin
{

    public function initialize()
    {
        parent::initialize();
        if ($this->getConfig()->offsetExists('site_key')
            && $this->getConfig()->offsetExists('secret_key')) {
            Extend::regm(array(
                'tpl.head' => array($this, 'onHead'),
                'captcha.init' => array($this, 'onCaptchaInit'),
                'captcha.check' => array($this, 'onCaptchaCheck'),
            ));
        }
    }

    protected function getConfigDefaults()
    {
        return array(
            'site_key' => null,
            'secret_key' => null,
        );
    }

    /**
     * @param array $args
     */
    public function onHead(array $args)
    {
        if (!_logged_in) {
            $args['js_before'] .= "\n<script type='text/javascript' src='https://www.google.com/recaptcha/api.js'></script>";
        }
    }

    /**
     * @param array $args
     */
    public function onCaptchaInit($args)
    {
        if (!_logged_in) {
            $args['value'] = array(
                'label' => _lang('captcha.input'),
                'content' => "<div class='g-recaptcha' data-sitekey='" . $this->getConfig()->offsetGet('site_key') . "'></div>",
                'top' => true,
                'class' => ''
            );
        }
    }

    /**
     * @param $args
     */
    public function onCaptchaCheck($args)
    {
        if (!_logged_in) {
            if (isset($_POST['g-recaptcha-response'])) {
                $requestMethod = null;
                if (!ini_get('allow_url_fopen')) {
                    $requestMethod = new SocketPost();
                }
                $recaptcha = new ReCaptcha($this->getConfig()->offsetGet('secret_key'), $requestMethod);
                $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
                $args['value'] = $resp->isSuccess();
            } else {
                $args['value'] = false;
            }
        }
    }

}

<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
     /*'di'=> array(
        'instance'=>array(
            'alias'=>array(
                // OTHER ELEMENTS....
                'recaptcha_element' => 'Zend\Form\Element\Captcha',
            ),
            'recaptcha_element' => array(
                'parameters' => array(
                    'spec' => 'captcha',
                    'options'=>array(
                        'label'      => '',
                        'required'   => true,
                        'order'      => 500,
                        'captcha'    => array(
                            'captcha' => 'ReCaptcha',
                            'privkey' => RECAPTCHA_PRIVATE_KEY,
                            'pubkey'  => RECAPTCHA_PUBLIC_KEY,
                        ),
                    ),
                ),
            ),
            'ZfcUser\Form\Register' => array(
                'parameters' => array(
                    'captcha_element'=>'recaptcha_element',
                ),
            ),
        ),
     ),*/
);

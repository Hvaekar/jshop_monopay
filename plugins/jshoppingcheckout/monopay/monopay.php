<?php
defined('_JEXEC') or die('Restricted access');

class plgJshoppingCheckoutMonopay extends JPlugin
{

    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }

    public function onBeforeDisplayCheckoutStep5($sh_method, $pm_method, $delivery_info, $cart, &$view)
    {
        if ($pm_method->payment_class != "pm_monopay") return;
        JSFactory::loadExtLanguageFile("monopay");

        $view->monopay_scripts .= '<script>btn = document.getElementById("previewfinish_btn"); btn.value = "' . _JSHOP_MONOPAY_SUCCESS_BTN . '";</script>';
    }

    public function onBeforeDisplayCheckoutStep5View(&$view)
    {
        $view->_tmp_ext_html_previewfinish_end .= $view->monopay_scripts;
    }

}


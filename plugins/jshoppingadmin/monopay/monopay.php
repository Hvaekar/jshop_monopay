<?php
defined('_JEXEC') or die('Restricted access');

class plgJshoppingAdminMonopay extends JPlugin
{

    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }

    public function onBeforeShowOrder(&$view)
    {
        JSFactory::loadExtLanguageFile("monopay");

        $pm_method = $view->order->getPayment();
        if ($pm_method->payment_class != "pm_monopay") return;
        $pm_configs = $pm_method->getConfigs();
        if (!$pm_configs['return_money']) return;

        $current_status = $this->getCurrentStatus($view->order->transaction, $pm_configs['secret']);
        if (!$current_status->errCode) {
            $final_amount = $current_status->finalAmount / 100;
        } else {
            \JFactory::getApplication()->enqueueMessage(
                \JText::_('JERROR_ERROR') . ' ' . $current_status->errCode . ' (' . $current_status->errText . ')', 'danger');
            return;
        }
        if ($final_amount == 0) return;

        $order_currency = $this->getCurrency($view->order->currency_code_iso);

        if ($order_currency->currency_code_num != $current_status->ccy) {
            $final_amount = $final_amount * $view->order->currency_exchange;
        }

        if ($final_amount > 0) {
            $view->_update_status_html .= '<tr><td><label for="monopay_return">' . _JSHOP_MONOPAY_RETURN_MONEY . '</label></td> <td><input type="number" step="0.01" id="monopay_return" name="monopay_return" class="inputbox form-control" min="0" max="' . $final_amount . '" placeholder="' . _JSHOP_ENTER_SUMM . '">' . $view->order->currency_code . '</td> <td><button class="btn btn-warning" type="button" onclick="add_subtotal(' . $final_amount . ')">' . _JSHOP_ADD_ALL_SUBTOTAL . '</button></td></tr>';
            $view->_update_status_html .= '<input type="hidden" name="monopay_final_amount" value="' . $final_amount . '">';
            $view->_update_status_html .= '<script>
                    function add_subtotal(value){
                        document.getElementById("monopay_return").value=value;
                    }
                    
                    const btnUpdate = document.getElementsByName("update_status")[0];
                    const btnUpdateAttr = btnUpdate.getAttribute("onclick");
                    var return_alert = function() {
                        let returnVal = document.getElementById("monopay_return").value
                        if (returnVal > 0) {
                            if (confirm("' . _JSHOP_MONOPAY_ALERT . '".replace("%s", returnVal + "' . $view->order->currency_code . '"))) {
                                return true;
                            } else {
                                return false;
                            };
                        } else {
                            return true;
                        }
                    };
                    btnUpdate.setAttribute( "onclick", "if (return_alert()){" + btnUpdateAttr + "}");
                </script>';
        }
    }

    private function getCurrency($currency_code_iso)
    {
        $db = \JFactory::getDBO();
        $query_where = "WHERE currency_code_iso = '" . $currency_code_iso . "'";
        $query = "SELECT * FROM `#__jshopping_currencies` $query_where";
        $db->setQuery($query);
        return $db->loadObJect();
    }

    private function getCurrentStatus($invoice_id, $secret)
    {
        $host = 'https://api.monobank.ua/api/merchant/invoice/status?invoiceId=' . $invoice_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'X-Token: ' . $secret));
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        return $result;
    }
}
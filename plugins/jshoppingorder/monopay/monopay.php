<?php
defined('_JEXEC') or die('Restricted access');

class plgJshoppingOrderMonopay extends JPlugin
{

    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }

    public function onBeforeChangeOrderStatusAdmin(
        $order_id, $status, $status_id, $notify, $comments, $include_comment, $view_order, $prev_status, &$return
    )
    {
        JSFactory::loadExtLanguageFile("monopay");
        $host = 'https://api.monobank.ua/api/merchant/invoice/cancel';

        // get main fields
        $jinp = \JFactory::getApplication()->input;
        $monopay_return = round(floatval($jinp->get('monopay_return')), 2);
        $monopay_invoice_id = strval($jinp->get('monopay_invoice_id'));
        if (!$monopay_invoice_id || !$monopay_return) return;

        // get order
        $order = \JSFactory::getTable('order');
        $order->load($order_id);

        // get payment from order
        $pm_method = $order->getPayment();
        if ($pm_method->payment_class != "pm_monopay") return;
        $pm_configs = $pm_method->getConfigs();
        if (!$pm_configs['return_money']) return;

        // check current status of payment
        $current_status = $this->getCurrentStatus($monopay_invoice_id, $pm_configs['secret']);
        if (!$current_status->errCode) {
            $final_amount = $current_status->finalAmount / 100;
        } else {
            $return = 0;
            \JFactory::getApplication()->enqueueMessage(
                \JText::_('JERROR_ERROR') . ' ' . $current_status->errCode . ' (' . $current_status->errText . ')', 'danger');
            return;
        }
        if ($final_amount == 0) return;

        // final amount
        $order_currency = $this->getCurrency($order->currency_code_iso);
        if ($order_currency[0]->currency_code_num != $current_status->ccy) {
            $final_amount = $final_amount * $order->currency_exchange;
        }

        if ($monopay_return > $final_amount || $monopay_return < 0) {
            $return = 0;
            \JFactory::getApplication()->enqueueMessage(
                sprintf(_JSHOP_MONOPAY_INVALID_RETURN_SUMM, $final_amount . $order->currency_code), 'danger');
            return;
        }

        if ($order_currency[0]->currency_code_num != $current_status->ccy) {
            $monopay_return = $monopay_return / $order->currency_exchange;
        }

        // prepare data for request
        $return_args = array(
            "invoiceId" => $monopay_invoice_id,
            "amount" => intval($monopay_return * 100),
        );

        $data = json_encode($return_args, JSON_UNESCAPED_UNICODE);

        // request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'X-Token: ' . $pm_configs['secret']));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = json_decode(curl_exec($ch));
        if ($result->errCode != '') {
            $return = 0;
            \JFactory::getApplication()->enqueueMessage($result->errText, 'danger');
        } else {
            switch ($result->status) {
                case 'success':
                    \JFactory::getApplication()->enqueueMessage(
                        sprintf(_JSHOP_MONOPAY_RETURN_SUCCESS, $monopay_return * $order->currency_exchange . $order->currency_code), 'success');
                    break;
                case 'processing':
                    \JFactory::getApplication()->enqueueMessage(
                        sprintf(_JSHOP_MONOPAY_RETURN_PROCESSING, $monopay_return * $order->currency_exchange . $order->currency_code), 'warning');
                    break;
                case 'failure':
                    $return = 0;
                    \JFactory::getApplication()->enqueueMessage(
                        sprintf(_JSHOP_MONOPAY_RETURN_FAILURE, $monopay_return * $order->currency_exchange . $order->currency_code), 'danger');
                    break;
                default:
                    $return = 0;
                    \JFactory::getApplication()->enqueueMessage(_JSHOP_MONOPAY_RETURN_UNKNOWN_ERROR, 'danger');
                    break;
            }
        }
        curl_close($ch);
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

    private function getCurrency($currency_code_iso)
    {
        $db = \JFactory::getDBO();
        $query_where = "WHERE currency_code_iso = '" . $currency_code_iso . "'";
        $query = "SELECT currency_id, currency_name, currency_code, currency_code_num, currency_value FROM `#__jshopping_currencies` $query_where";
        $db->setQuery($query);
        return $db->loadObJectList();
    }
}
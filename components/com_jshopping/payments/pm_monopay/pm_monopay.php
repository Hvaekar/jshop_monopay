<?php
defined('_JEXEC') or die('Restricted access');

class pm_monopay extends PaymentRoot
{
    function showAdminFormParams($params)
    {
        $array_params = array(
            'secret', 'currency', 'transaction_end_status', 'transaction_pending_status', 'transaction_failed_status', 'return_check', 'qr_id', 'return_money');
        foreach ($array_params as $key) {
            if (!isset($params[$key])) $params[$key] = '';
        }
        $orders = JModelLegacy::getInstance('orders', 'JshoppingModel'); //admin model
        JSFactory::loadExtAdminLanguageFile('monopay');
        include(dirname(__FILE__) . "/adminparamsform.php");
    }

    function checkTransaction($pmconfigs, $order, $act)
    {
        \JSFactory::loadExtLanguageFile('monopay');
        $callback = JFactory::$application->input->post->getArray();
        if (empty($callback)) {
            $fap = json_decode(file_get_contents("php://input"));
            foreach ($fap as $key => $val) {
                $callback[$key] = $val;
            }
        }

        $payment_status = trim($callback['status']);
        $transaction = $callback['invoiceId'];
        $transactiondata = array(
            'invoiceId' => $callback['invoiceId'],
            'status' => $callback['status'],
            'failureReason' => $callback['failureReason'],
            'amount' => $callback['amount'],
            'ccy' => $callback['ccy'],
            'finalAmount' => $callback['finalAmount'],
            'createdDate' => $callback['createdDate'],
            'modifiedDate' => $callback['modifiedDate'],
        );

        if ($payment_status) {
            $transactiondata['link'] = 'https://pay.mbnk.biz/' . $callback['invoiceId'];
            $status = $this->getStatus($pmconfigs, $payment_status, $callback['failureReason']);
            $status[] = $transaction;
            $status[] = $transactiondata;
            return $status;
        } else {
            $invoice_id = $order->transaction;
            if (!$invoice_id) {
                $transactions = $order->getListTransactions();
                foreach ($transactions[0]->data as $trx_data) {
                    if ($trx_data->key == "invoiceId") {
                        $invoice_id = $trx_data->value;
                    }
                }
            }
            $current_status = $this->getCurrentStatus($invoice_id, $pmconfigs['secret']);
            $status = $this->getStatus($pmconfigs, $current_status->status, $current_status->failureReason);
            $status[] = $invoice_id;
            $status[] = array(_MONOPAY_SUCCESS_SECOND_TIME => $current_status->status);
            return $status;
        }
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

    function getStatus($pmconfigs, $payment_status, $failure_reason = '')
    {
        if (!$pmconfigs['return_check']) {
            $waiting = 2;
            $error = 3;
        }

        switch ($payment_status) {
            case 'success':
                return array(1, _MONOPAY_SUCCESS);
            case 'created':
                return array(0, _MONOPAY_CREATED);
            case 'processing':
                return array($waiting, _MONOPAY_PROCESSING);
            case 'hold':
                return array($error, _MONOPAY_HOLD);
            case 'failure':
                return array($error, _MONOPAY_FAILURE . ' ' . $failure_reason);
            case 'expired':
                return array($error, _MONOPAY_EXPIRES);
            case 'reversed':
                // add status reverced in admin and login to change order status
                return array(0, _MONOPAY_REVERCED);
            default:
                return array(0, _MONOPAY_ERROR);
        }
    }

    function showEndForm($pmconfigs, $order)
    {
        $jshopConfig = \JSFactory::getConfig();
        \JSFactory::loadExtLanguageFile('monopay');
        $pm_method = $this->getPmMethod();

        $host = "https://api.monobank.ua/api/merchant/invoice/create";
        $notify_url = JURI::root() . \JSHelper::SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=" . $pm_method->payment_class . '&order_id=' . $order->order_id, 1);

        if ($pmconfigs['return_check']) {
            $success_url = JURI::root() . \JSHelper::SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=finish&js_paymentclass=" . $pm_method->payment_class . '&order_id=' . $order->order_id, 1);
        } else {
            $success_url = JURI::root() . \JSHelper::SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=" . $pm_method->payment_class . '&order_id=' . $order->order_id, 1);
        }

        if ($this->cancel_url_step5) {
            $cancel_return = JURI::root() . \JSHelper::SEFLink("index.php?option=com_jshopping&controller=checkout&task=step5", 1);
        } else {
            $cancel_return = JURI::root() . \JSHelper::SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=" . $pm_method->payment_class . '&order_id=' . $order->order_id, 1);
        }

        if (!$pmconfigs['currency']) {
            $currency = $this->getCurrency($order->currency_code_iso);
        } else {
            $currency = $this->getCurrency($pmconfigs['currency']);
        }

        if ($pmconfigs['currency'] != $order->currency_code_iso) {
            $order->order_total = $order->order_total * $currency->currency_value / $order->currency_exchange;
        }

        $ccy = intval($currency->currency_code_num);


        $mono_args = array(
            "amount" => round($this->fixOrderTotal($order) * 100),
            "ccy" => $ccy,
            "redirectURL" => $success_url,
            "webHookUrl" => $notify_url,
            "merchantPaymInfo" => array(
                "reference" => strval($order->order_id),
                "destination" => _JSHOP_DESTINATION_PRE . ltrim($order->order_number, '0'),
            ),
        );

        if ($pmconfigs['qr_id']) $mono_args['qrId'] = $pmconfigs['qr_id'];

        $order_items = $order->getAllItems();
        $basket_order = array();
        foreach ($order_items as $item) {
            if ($pmconfigs['currency'] != $order->currency_code_iso) {
                $item->product_item_price = $item->product_item_price * $currency->currency_value / $order->currency_exchange;
            }

            if ($item->product_attributes) {
                $item->product_name .= ' ('.trim($item->product_attributes).')';
            }

            $basket_item = array(
                "name" => trim($item->product_name),
                "qty" => intval($item->product_quantity),
                "sum" => round($item->product_item_price*100),
                "code" => trim($item->product_ean),
            );

            if ($item->thumb_image) {
                $basket_item["icon"] = $jshopConfig->image_product_live_path.'/'.$item->thumb_image;
            }

            $basket_order[] = $basket_item;
        }
        $mono_args['merchantPaymInfo']['basketOrder'] = $basket_order;

        $data = json_encode($mono_args, JSON_UNESCAPED_UNICODE);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'X-Token: ' . $pmconfigs['secret']));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = json_decode(curl_exec($ch));
        if ($result->errCode != '' || $result->invoiceId == '') {
            \JSHelper::saveToLog("payment.log", "Status pending. Order ID " . $order->order_id . ". " . $result->errText);
        }
        curl_close($ch);

        if ($result->pageUrl) {
            header('Location: ' . $result->pageUrl);
        } else {
            header('Location: https://pay.mbnk.biz/' . $result->invoiceId);
        }
    }

    function getCurrency($currency_code_iso)
    {
        $db = \JFactory::getDBO();
        $query_where = "WHERE currency_code_iso = '" . $currency_code_iso . "'";
        $query = "SELECT * FROM `#__jshopping_currencies` $query_where";
        $db->setQuery($query);
        return $db->loadObJect();
    }

    function getUrlParams($pmconfigs)
    {
        $params = array();
        $input = JFactory::$application->input;
        $params['order_id'] = $input->getInt('order_id', null);
        $params['hash'] = "";
        $params['checkHash'] = 0;
        $params['checkReturnParams'] = $pmconfigs['return_check'];
        return $params;
    }

    function fixOrderTotal($order)
    {;
        if ($order->currency_code_iso == 'HUF') {
            $total = round($order->order_total);
        } else {
            $total = number_format($order->order_total, 2, '.', '');
        }
        return $total;
    }

}

?>


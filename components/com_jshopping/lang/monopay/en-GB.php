<?php
defined('_JEXEC') or die('Restricted access');

define('_JSHOP_MONOPAY_SECRET',"Token");
define('_JSHOP_MONOPAY_QR_ID',"QR cash register ID");
define('_JSHOP_MONOPAY_TRANSACTION_END',"Order Status for successful transactions");
define('_JSHOP_MONOPAY_TRANSACTION_PENDING',"Order Status for Pending Payments");
define('_JSHOP_MONOPAY_TRANSACTION_FAILED',"Order Status for failed transactions");
define('_JSHOP_DESTINATION_PRE',"Payment order #");
define('_JSHOP_MONOPAY_CURRENCY',"Currency");
define('_JSHOP_MONOPAY_CURRENCY_DEFAULT',"Order currency");
define('_JSHOP_MONOPAY_CHECK_RETURN',"Check data upon return");
define('_JSHOP_MONOPAY_CHECK_RETURN_DESC',"'Yes' - the order will be created as unfinished until the moment of payment confirmation, statuses will not change, returning to the site will lead to the order confirmation page. 'No' - the statuses will change starting with the process of confirmation of payment by the client in the bank, returning to the site in any case will complete the order and the client will receive the final page 'Thank you...'");
define('_MONOPAY_SUCCESS',"Order paid.");
define('_MONOPAY_CREATED',"The order has been created. The invoice is awaiting payment.");
define('_MONOPAY_PROCESSING',"Order created. Awaiting payment.");
define('_MONOPAY_HOLD',"The order has not been paid. The amount is blocked.");
define('_MONOPAY_FAILURE',"Order not paid.");
define('_MONOPAY_EXPIRES',"Order not paid. Account has expired.");
define('_MONOPAY_REVERCED',"Order returned. Funds returned.");
define('_MONOPAY_ERROR',"Unknown error.");
define('_MONOPAY_SUCCESS_SECOND_TIME',"Checked upon completion");
define('_MONOPAY_SUCCESS_SECOND_TIME_YES',"Yes");
define('_JSHOP_MONOPAY_RETURN_MONEY',"Return money (MonoPay)");
define('_JSHOP_MONOPAY_RETURN_MONEY_DESC',"'No' - it will not be possible to return funds through the administration; 'Yes' - it will be possible");
define('_JSHOP_ENTER_SUMM',"Enter summ");
define('_JSHOP_ADD_ALL_SUBTOTAL',"All subtotal");
define('_JSHOP_MONOPAY_INVALID_RETURN_SUMM',"Invalid summ fore return. Max summ %s.");
define('_JSHOP_MONOPAY_RETURN_SUCCESS',"Money returned: %s");
define('_JSHOP_MONOPAY_RETURN_PROCESSING',"Money in process of return: %s");
define('_JSHOP_MONOPAY_RETURN_FAILURE',"Money return error: %s");
define('_JSHOP_MONOPAY_ALERT',"Are you shure to return %s?");

define('_JSHOP_MONOPAY_DESC_LINE1',"An application to connect Mono acquiring is submitted here: <a href='https://www.monobank.ua/e-comm'>https://www.monobank.ua/e-comm</a>");
define('_JSHOP_MONOPAY_DESC_LINE2',"After opening access by the bank, in the personal account on the website <a href='https://web.monobank.ua/'>https://web.monobank.ua/</a> in the section 'Internet -> Acquiring Management' create a token, copy it and paste it here in the 'Token' field. Save.");
define('_JSHOP_MONOPAY_DESC_LINE3',"A test token can be generated here: <a href='https://api.monobank.ua/'>https://api.monobank.ua/</a>");
define('_JSHOP_MONOPAY_DESC_LINE4',"For chocolate: <a href='https://send.monobank.ua/6RdYrEoiDx'>send</a>");
?>
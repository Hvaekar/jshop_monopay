<?php
defined('_JEXEC') or die('Restricted access');
\JSFactory::loadExtLanguageFile('monopay');

$currencies = \JSFactory::getAllCurrency();
$curr_options = array();
$curr_options[] = _JSHOP_MONOPAY_CURRENCY_DEFAULT;
foreach ($currencies as $v) {
    $curr_options[$v->currency_code_iso] = $v->currency_name;
}

$yes_no_options = array();
$yes_no_options[] = \JText::_('JNO');
$yes_no_options[] = \JText::_('JYES');
?>
<div class="col100">
    <fieldset class="adminform">
        <table class="admintable" width="100%">
            <tr>
                <td class="key">
                    <?php echo _JSHOP_MONOPAY_SECRET; ?>
                </td>
                <td>
                    <input type="text" class="inputbox form-control" name="pm_params[secret]" size="45"
                           value="<?php echo $params['secret'] ?>"/>
                </td>
            </tr>

            <!--<tr>
                <td class="key">
                    <?php echo _JSHOP_MONOPAY_QR_ID; ?>
                </td>
                <td>
                    <input type="text" class="inputbox form-control" name="pm_params[qr_id]" size="45"
                           value="<?php echo $params['qr_id'] ?>"/>
                </td>
            </tr>-->

            <tr>
                <td class="key">
                    <?php echo _JSHOP_MONOPAY_CURRENCY; ?>
                </td>
                <td>
                    <?php
                    print \JHTML::_('select.genericlist', $curr_options, 'pm_params[currency]', 'class = "inputbox custom-select" size = "1" style="max-width:240px; display: inline-block"', 'currency_id', 'name', $params['currency']);
                    ?>
                </td>
            </tr>

            <tr>
                <td class="key">
                    <?php echo \JText::_('JSHOP_TRANSACTION_END') ?>
                </td>
                <td>
                    <?php
                    print \JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox custom-select" size = "1" style="max-width:240px; display: inline-block"', 'status_id', 'name', $params['transaction_end_status']);
                    echo " " . \JSHelperAdmin::tooltip(\JText::_('JSHOP_PAYPAL_TRANSACTION_END_DESCRIPTION'));
                    ?>
                </td>
            </tr>
            <tr>
                <td class="key">
                    <?php echo \JText::_('JSHOP_TRANSACTION_PENDING') ?>
                </td>
                <td>
                    <?php
                    echo \JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_pending_status]', 'class = "inputbox custom-select" size = "1" style="max-width:240px; display: inline-block"', 'status_id', 'name', $params['transaction_pending_status']);
                    echo " " . \JSHelperAdmin::tooltip(\JText::_('JSHOP_PAYPAL_TRANSACTION_PENDING_DESCRIPTION'));
                    ?>
                </td>
            </tr>
            <tr>
                <td class="key">
                    <?php echo \JText::_('JSHOP_TRANSACTION_FAILED') ?>
                </td>
                <td>
                    <?php
                    echo \JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_failed_status]', 'class = "inputbox custom-select" size = "1" style="max-width:240px; display: inline-block"', 'status_id', 'name', $params['transaction_failed_status']);
                    echo " " . \JSHelperAdmin::tooltip(\JText::_('JSHOP_PAYPAL_TRANSACTION_FAILED_DESCRIPTION'));
                    ?>
                </td>
            </tr>

            <tr>
                <td class="key">
                    <label class="hasTooltip"
                           title="<?php echo _JSHOP_MONOPAY_CHECK_DESC; ?>"><?php echo _JSHOP_MONOPAY_CHECK_RETURN; ?></label>
                </td>
                <td>
                    <?php
                    echo \JHTML::_('select.genericlist', $yes_no_options, 'pm_params[return_check]', 'class = "inputbox custom-select" size = "1" style="max-width:240px; display: inline-block"', 'status_id', 'name', $params['return_check']);
                    echo " " . \JSHelperAdmin::tooltip(_JSHOP_MONOPAY_CHECK_RETURN_DESC);
                    ?>
                </td>
            </tr>

            <tr>
                <td class="key">
                    <label class="hasTooltip"
                           title="<?php echo _JSHOP_MONOPAY_RETURN_MONEY_DESC; ?>"><?php echo _JSHOP_MONOPAY_RETURN_MONEY; ?></label>
                </td>
                <td>
                    <?php
                    echo \JHTML::_('select.genericlist', $yes_no_options, 'pm_params[return_money]', 'class = "inputbox custom-select" size = "1" style="max-width:240px; display: inline-block"', 'status_id', 'name', $params['return_money']);
                    echo " " . \JSHelperAdmin::tooltip(_JSHOP_MONOPAY_RETURN_MONEY_DESC);
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
</div>
<div class="clr"></div>
<div style="margin-top: 100px;">
    <div><?php print _JSHOP_MONOPAY_DESC_LINE1 ?></div>
    <div><?php print _JSHOP_MONOPAY_DESC_LINE2 ?></div>
    <div><?php print _JSHOP_MONOPAY_DESC_LINE3 ?></div>
    <div style="margin-top: 30px;"><?php print _JSHOP_MONOPAY_DESC_LINE4 ?></div>
</div>
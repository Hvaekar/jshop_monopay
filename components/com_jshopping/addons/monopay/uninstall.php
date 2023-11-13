<?php
defined('_JEXEC') or die('Restricted access');

$db = \JFactory::getDbo();

$db->setQuery("DELETE FROM `#__extensions` WHERE element = 'monopay' AND folder = 'jshoppingorder' AND `type` = 'plugin'");
$db->execute();

$db->setQuery("DELETE FROM `#__extensions` WHERE element = 'monopay' AND folder = 'jshoppingadmin' AND `type` = 'plugin'");
$db->execute();

$db->setQuery("DELETE FROM `#__extensions` WHERE element = 'monopay' AND folder = 'jshoppingcheckout' AND `type` = 'plugin'");
$db->execute();

$db->setQuery("DELETE FROM `#__jshopping_payment_method` WHERE payment_code = 'monopay'");
$db->execute();

jimport('joomla.filesystem.folder');
foreach (array(
             'components/com_jshopping/addons/monopay/',
             'components/com_jshopping/lang/monopay/',
             'components/com_jshopping/payments/pm_monopay/',
             'plugins/jshoppingadmin/monopay/',
             'plugins/jshoppingorder/monopay/',
             'plugins/jshoppingcheckout/monopay/',
         ) as $folder) {
    JFolder::delete(JPATH_ROOT . '/' . $folder);
}
<?php
defined('_JEXEC') or die('Restricted access');

define('_MONO',"mono");
define('_JSHOP_MONOPAY_SECRET',"Токен");
define('_JSHOP_MONOPAY_QR_ID',"Идентификатор QR-кассы");
define('_JSHOP_MONOPAY_TRANSACTION_END',"Статус заказа после успешной оплаты");
define('_JSHOP_MONOPAY_TRANSACTION_PENDING',"Статус заказа при ожидании оплаты");
define('_JSHOP_MONOPAY_TRANSACTION_FAILED',"Статус заказа при ошибке оплаты");
define('_JSHOP_DESTINATION_PRE',"Оплата заказа №");
define('_JSHOP_MONOPAY_CURRENCY',"Валюта");
define('_JSHOP_MONOPAY_CURRENCY_DEFAULT',"Валюта заказа");
define('_JSHOP_MONOPAY_CHECK_RETURN',"Проверять данные по возвращению");
define('_JSHOP_MONOPAY_CHECK_RETURN_DESC',"'Да' – заказ будет создан как незаконченный до момента подтверждения оплаты, статусы меняться не будут, возврат на сайт приведет на страницу подтверждения заказа. 'Нет' - статусы будут меняться начиная с процесса подтверждения оплаты клиентом в банке, возврат на сайт в любом случае завершит заказ и клиенту выдаст конечную страницу 'Спасибо...'");
define('_MONOPAY_SUCCESS',"Заказ оплачен.");
define('_MONOPAY_CREATED',"Заказ создан. Счет ожидает оплату.");
define('_MONOPAY_PROCESSING',"Заказ создан. Ожидает оплату.");
define('_MONOPAY_HOLD',"Заказ не оплачен. Сумма заблокирована.");
define('_MONOPAY_FAILURE',"Заказ не оплачен.");
define('_MONOPAY_EXPIRES',"Заказ не оплачен. Время действия счета истекло.");
define('_MONOPAY_REVERCED',"Заказ возвращен. Средства возвращены.");
define('_MONOPAY_ERROR',"Неизвестная ошибка.");
define('_MONOPAY_SUCCESS_SECOND_TIME',"Проверено по завершению");
define('_MONOPAY_SUCCESS_SECOND_TIME_YES',"Да");
define('_JSHOP_MONOPAY_RETURN_MONEY',"Вернуть деньги (MonoPay)");
define('_JSHOP_MONOPAY_RETURN_MONEY_DESC',"'Нет' – возвращать средства через админку нельзя будет; 'Да' - можно будет");
define('_JSHOP_ENTER_SUMM',"Введите сумму");
define('_JSHOP_ADD_ALL_SUBTOTAL',"Всю сумму");
define('_JSHOP_MONOPAY_INVALID_RETURN_SUMM',"Неверно указана сумма возврата. Максимальная сумма %s.");
define('_JSHOP_MONOPAY_RETURN_SUCCESS',"Средства возващены: %s");
define('_JSHOP_MONOPAY_RETURN_PROCESSING',"Средства в процессе воврата: %s");
define('_JSHOP_MONOPAY_RETURN_FAILURE',"Ошибка возврата средств: %s");
define('_JSHOP_MONOPAY_RETURN_UNKNOWN_ERROR',"Неизвестная ошибка возврата.");
define('_JSHOP_MONOPAY_ALERT',"Вы действительно хотите вернуть %s?");

define('_JSHOP_MONOPAY_DESC_LINE1',"Заявка на подключение эквайринга Моно подается здесь: <a href='https://www.monobank.ua/e-comm'>https://www.monobank.ua/e-comm</a>");
define('_JSHOP_MONOPAY_DESC_LINE2',"После открытия доступа банком, в личном кабинете на сайте <a href='https://web.monobank.ua/'>https://web.monobank.ua/</a> в разделе 'Интернет -> Управление эквайрингом' создаете токен, копируете его и вставляете здесь в поле 'Токен'. Сохраняете.");
define('_JSHOP_MONOPAY_DESC_LINE3',"Тестовый токен можно сгенерировать здесь: <a href='https://api.monobank.ua/'>https://api.monobank.ua/</a>");
define('_JSHOP_MONOPAY_DESC_LINE4',"На шоколадку разработчику: <a href='https://send.monobank.ua/6RdYrEoiDx'>отправить</a>");
?>
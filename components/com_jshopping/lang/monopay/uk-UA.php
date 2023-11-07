<?php
defined('_JEXEC') or die('Restricted access');

define('_JSHOP_MONOPAY_SECRET',"Токен");
define('_JSHOP_MONOPAY_QR_ID',"Ідентифікатор QR-каси");
define('_JSHOP_MONOPAY_TRANSACTION_END',"Статус замовлення після успішної оплати");
define('_JSHOP_MONOPAY_TRANSACTION_PENDING',"Статус замовлення при очікуванні оплати");
define('_JSHOP_MONOPAY_TRANSACTION_FAILED',"Статус замовлення при помилці оплати");
define('_JSHOP_DESTINATION_PRE',"Оплата замовлення №");
define('_JSHOP_MONOPAY_CURRENCY',"Валюта");
define('_JSHOP_MONOPAY_CURRENCY_DEFAULT',"Валюта замовлення");
define('_JSHOP_MONOPAY_CHECK_RETURN',"Перевіряти дані щодо повернення");
define('_JSHOP_MONOPAY_CHECK_RETURN_DESC',"'Ні' - замовлення буде перевизначено на 'закінчене' на етапі створення рахунку (форми оплати Моно), будуть змінюватися статуси по ходу процесу оплати, і при натисканні на кнопку 'Повернутись на сайт' клієнту підвантажиться сторінка завершеного замовлення. 'Так' - замовлення буде закінчуватися тільки при успіху оплати, статуси змінюватися не будуть, і при натисканні на кнопку 'Повернутися на сайт' підвантажиться останній крок оформлення замовлення.");
define('_MONOPAY_SUCCESS',"Замовлення оплачено.");
define('_MONOPAY_CREATED',"Замовлення створено. Рахунок очікує на оплату.");
define('_MONOPAY_PROCESSING',"Замовлення створено. Очікує оплату.");
define('_MONOPAY_HOLD',"Замовлення не сплачено. Сума заблокована.");
define('_MONOPAY_FAILURE',"Замовлення не сплачено.");
define('_MONOPAY_EXPIRES',"Замовлення не сплачено. Час дії рахунку закінчився.");
define('_MONOPAY_REVERCED',"Замовлення повернуто. Кошти повернуто.");
define('_MONOPAY_ERROR',"Невідома помилка.");
define('_MONOPAY_SUCCESS_SECOND_TIME',"Перевірено по завершенню");
define('_MONOPAY_SUCCESS_SECOND_TIME_YES',"Так");
define('_JSHOP_MONOPAY_RETURN_MONEY',"Повернути кошти (MonoPay)");
define('_JSHOP_MONOPAY_RETURN_MONEY_DESC',"'Ні' - повертати кошти через адмінку не можна буде; 'Так' - можна буде");
define('_JSHOP_ENTER_SUMM',"Введіть суму");
define('_JSHOP_ADD_ALL_SUBTOTAL',"Всю суму");
define('_JSHOP_MONOPAY_INVALID_RETURN_SUMM',"Невірно вказана сума повернення. Максимальна сума %s.");
define('_JSHOP_MONOPAY_RETURN_SUCCESS',"Кошти повернуті: %s");
define('_JSHOP_MONOPAY_RETURN_PROCESSING',"Кошти в процесі повернення: %s");
define('_JSHOP_MONOPAY_RETURN_FAILURE',"Помилка повернення коштів: %s");
define('_JSHOP_MONOPAY_RETURN_UNKNOWN_ERROR',"Невідома помилка повернення.");
define('_JSHOP_MONOPAY_ALERT',"Ви дійсно хочете повернути %s?");

define('_JSHOP_MONOPAY_DESC_LINE1',"Заявка на підключення еквайрингу Моно подається тут: <a href='https://www.monobank.ua/e-comm'>https://www.monobank.ua/e-comm</a>");
define('_JSHOP_MONOPAY_DESC_LINE2',"Після відкриття доступу банком, в особистому кабінеті на сайті <a href='https://web.monobank.ua/'>https://web.monobank.ua/</a> в розділі 'Інтернет -> Управляння еквайрингом' створюєте токен, копіюєте його і вставляєтут тут в поле 'Токен'. Зберігаєте.");
define('_JSHOP_MONOPAY_DESC_LINE3',"Тестовий токен можна згенерувати тут: <a href='https://api.monobank.ua/'>https://api.monobank.ua/</a>");
define('_JSHOP_MONOPAY_DESC_LINE4',"На чоколадку розробнику: <a href='https://send.monobank.ua/6RdYrEoiDx'>відправити</a>");
?>
<?php

         define('HEADING_TITLES','Оформление заказа');
         define('TEXT_GREETING', 'Если Вы наш постоянный клиент, <b><a href='.FILENAME_LOGIN.'><u> введите Ваши персональные данные</u></a></b> для входа.<br>  Если Вы у нас впервые и хотите сделать заказ, Вы можете <a href='.FILENAME_CREATE_ACCOUNT.'><u><b> зарегистрироваться</b></u></a>. <br><br>Eсли Вы не хотите регистрироваться, Вы можете оформить "быстрый заказ" без регистрации, для этого заполните форму ниже.');
         define('TITLE_SHIPPING_ADDRESS', 'Адрес доставки:');
         define('TABLE_HEADING_SHIPPING_METHOD', 'Способ доставки');
         define('TITLE_FORM', 'Быстрый заказ');
         define('TEXT_ENTER_SHIPPING_INFORMATION', '');
         define('TEXT_CHOOSE_SHIPPING_METHOD', 'Доступные способы доставки заказа.');
         define('PRIMARY_ADDRESS_DESCRIPTION', 'Регистрируясь в магазине, у Вас будет возможность следить за этапами исполнения Вашего заказа.');
         define('TABLE_QUANTITY', 'Количество: ');
         define('TABLE_PRICE', 'Стоимость: ');
         define('TABLE_SPECIAL_PRICE', 'Спец. цена: ');
         define('TITLE_TOTAL', 'Всего:');
         define('TITLE_METHOD_PAYMENT', 'Способ оплаты');
         define('TITLE_DATE', 'Желаемая дата и время доставки');
         define('TITLE_TIME_SHIPMENT', 'Укажите желаемую дату доставки');
         define('TITLE_PAYMENT_ADDRESS', 'Покупатель');
         define('PAYMENT_TEXT', 'Все поля обязательны для заполнения и проверяются на подлинность. В случае необходимости мы должны иметь возможность позвонить Вам по указанному телефону.');
         define('PAYMENT_SHIPMENT', 'Нажмите стрелку, если адрес покупателя и адрес доставки различные:');
         define('ENTRY_COMMENTS', 'Комментарии к заказу:');
         define('ENTRY_HOWKNOW', 'Как Вы узнали о нашем магазине:');
         define('TITLE_SHIPPING_OWNER', 'Получатель:');
         define('HEADING_PRODUCTS', 'Товары');
         define('TEXT_EDIT', 'Редактировать');

define('EMAIL_SUBJECT', 'Добро пожаловать в ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Уважаемый %s!' . "\n\n");
define('EMAIL_GREET_MS', 'Уважаемая %s!' . "\n\n");
define('EMAIL_GREET_NONE', 'Уважаемый %s!' . "\n\n");
define('EMAIL_WELCOME', 'Мы рады пригласить Вас в интернет-магазин <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_CONTACT', 'Если у Вас возникли какие-либо вопросы, пишите: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_TEXT', 'Теперь Вы можете воспользоваться <b>дополнительными услугами</b>, которые мы рады Вам предложить. Эти услуги включают:' . "\n\n" . '<li><b>Постоянная корзина</b> - Любые товары, добавленные в корзину остаются там до тех пор, пока Вы не решите их приобрести или пока не удалите их из корзины.' . "\n" . '<li><b>Адресная книга</b> - Мы можем доставить приобретенные Вами товары по указанному адресу, а не только на Ваш домашний адрес! Это - отличное предложение, чтобы посылать подарки ко дню рождения или на праздники, Вашим родственникам и друзьям, даже если они живут в другом городе.' . "\n" . '<li><b>История Заказов</b> - Здесь Вы можете посмотреть историю заказов, которые Вы сделали в нашем магазине.' . "\n" . '<li><b>Обзоры продуктов</b> - Теперь наши покупатели могут высказать свое мнение о товарах, приобретенных в нашем магазине. Ваше мнение будет доступно широкой аудитории покупателей, которые наверняка нуждаются в потребительской оценке различных товаров' . "\n\n");
define('EMAIL_WARNING', '<b>Внимание:</b> Этот email адрес был предоставлен нам одним из наших клиентов. Если Вы еще не зарегистрировались и не являетесь членом нашего клуба потребителей, сообщите нам об этом на ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");

/* ICW Credit class gift voucher begin */
define('EMAIL_GV_INCENTIVE_HEADER', "\n\n" .'Также сообщам Вам, что Вы получаете сертификат на сумму %s');
define('EMAIL_GV_REDEEM', 'Код Вашего сертификата %s, Вы можете использовать Ваш сертификат при оплате заказа, при этом номинальная стоимость сертификата будет засчитана в качестве оплаты всего заказа, или в качестве оплаты части стоимости Вашего заказа.');
define('EMAIL_GV_LINK', 'Перейдите по ссылке для активизации сертификата: ');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Поздравляем с регистрацией в нашем магазине, рады сообщить, что мы дарим Вам купон на получение скидки в нашем магазине.' . "\n" .
                                        ' Данный купон действителен только для Вас.' . "\n");
define('EMAIL_COUPON_REDEEM', 'Чтобы воспользоваться купоном, Вы должны указать код купона в процессе оформления заказа, чтобы получить скидку.' . "\n" . 'Код Вашего купона: %s'); 

/* ICW Credit class gift voucher end */


?>
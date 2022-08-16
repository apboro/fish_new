<?php

define('HEADING_TITLE', 'Новости');
define('HEADING_TITLE_SEARCH', 'Поиск:');
define('HEADING_TITLE_GOTO', 'Перейти:');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_NEWSDESK', 'Категории/Новости');
define('TABLE_HEADING_DATE', 'Дата добавления');
define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_STATUS', 'Статус');

define('IMAGE_NEW_STORY', 'Добавить новость');

define('TEXT_CATEGORIES', 'Категории:');
define('TEXT_SUBCATEGORIES', 'Подкатегории:');
define('TEXT_NEWSDESK', 'Новости:');
define('TEXT_NEW_NEWSDESK', 'Добавить новость в категорию &quot;%s&quot;');

define('TABLE_HEADING_LATEST_NEWS_HEADLINE', 'Заголовок');
define('TEXT_NEWS_ITEMS', 'Новости:');
define('TEXT_INFO_HEADING_DELETE_ITEM', 'Удалить');
define('TEXT_DELETE_ITEM_INTRO', 'Вы действительно хотите удалить эту новость?');

define('TEXT_LATEST_NEWS_HEADLINE', 'Заголовок:');
define('TEXT_NEWSDESK_CONTENT', 'Содержание:');

define('IMAGE_NEW_NEWS_ITEM', 'Добавить новость');

define('TEXT_NEWSDESK_STATUS', 'Статус:');
define('TEXT_NEWSDESK_DATE_AVAILABLE', 'Дата:');
define('TEXT_NEWSDESK_AVAILABLE', 'Активна');
define('TEXT_NEWSDESK_NOT_AVAILABLE', 'Неактивна');

define('TEXT_NEWSDESK_URL', 'URL адрес источника:');
define('TEXT_NEWSDESK_URL_WITHOUT_HTTP', '<small>(без http://)</small>');

define('TEXT_NEWSDESK_SUMMARY', 'Кратко:');
define('TEXT_NEWSDESK_CONTENT', 'Содержание:');
define('TEXT_NEWSDESK_HEADLINE', 'Заголовок:');

define('TEXT_NEWSDESK_DATE_AVAILABLE', 'Дата:');
define('TEXT_NEWSDESK_DATE_ADDED', 'Дата добавления:');

define('TEXT_NEWSDESK_ADDED_LINK_HEADER', "Ссылка, которую Вы добавили:");
define('TEXT_NEWSDESK_ADDED_LINK', '<a href="http://%s" target="blank"><u>http://%s</u></a>');

define('TEXT_NEWSDESK_PRICE_INFO', 'Цена:');
define('TEXT_NEWSDESK_TAX_CLASS', 'Налог:');
define('TEXT_NEWSDESK_AVERAGE_RATING', 'Средний рейтинг:');
define('TEXT_NEWSDESK_QUANTITY_INFO', 'Количество:');
define('TEXT_DATE_ADDED', 'Дата добавления:');
define('TEXT_DATE_AVAILABLE', 'Дата:');
define('TEXT_LAST_MODIFIED', 'Последние изменения:');
define('TEXT_IMAGE_NONEXISTENT', 'КАРТИНКА ОТСУТСТВУЕТ');
define('TEXT_NO_CHILD_CATEGORIES_OR_story', 'Добавьте новую категорию или новую новость в<br>&nbsp;<br><b>%s</b>');

define('TEXT_EDIT_INTRO', 'Внесите необходимые изменения');
define('TEXT_EDIT_CATEGORIES_ID', 'Код категории:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Название категории:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Картинка категории:');
define('TEXT_EDIT_SORT_ORDER', 'Порядок сортировки:');

define('TEXT_INFO_COPY_TO_INTRO', 'Выберите категорию, в которую Вы хотите скопировать эту новость');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Категории:');

define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Новая категория');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Изменить категорию');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Удалить категорию');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Переместить категорию');
define('TEXT_INFO_HEADING_DELETE_NEWS', 'Удалить новость');
define('TEXT_INFO_HEADING_MOVE_NEWS', 'Переместить новость');
define('TEXT_INFO_HEADING_COPY_TO', 'Копировать в');

define('TEXT_DELETE_CATEGORY_INTRO', 'Вы действительно хотите удалить эту категорию?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Вы действительно хотите удалить эту новость?');

define('TEXT_DELETE_WARNING_CHILDS', '<b>Внимание:</b> %s подкатегорий находятся в этой категории!');
define('TEXT_DELETE_WARNING_NEWSDESK', '<b>Внимание:</b> %s новостей находится в этой категории!');

define('TEXT_MOVE_NEWSDESK_INTRO', 'Выберите категорию, в которую Вы хотите переместить <b>%s</b>');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Выберите категорию, в которую Вы хотите переместить <b>%s</b>');
define('TEXT_MOVE', 'Переместить <b>%s</b> в:');

define('TEXT_NEW_CATEGORY_INTRO', 'Чтобы создать новую категорию, Вы должны заполнить следующую форму');
define('TEXT_CATEGORIES_NAME', 'Название категории:');
define('TEXT_CATEGORIES_IMAGE', 'Картинка категории:');
define('TEXT_SORT_ORDER', 'Порядок сортировки:');

define('EMPTY_CATEGORY', 'Пустая категория');

define('TEXT_HOW_TO_COPY', 'Способ копирования:');
define('TEXT_COPY_AS_LINK', 'Ссылка на новость');
define('TEXT_COPY_AS_DUPLICATE', 'Дублировать новость');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Ошибка: Нет ссылок на новости в этой же категории.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Ошибка: Каталог для хранения картинок не доступен для записи, установите соответствующие права доступа: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Ошибка: Каталог для хранения картинок отсутствует: ' . DIR_FS_CATALOG_IMAGES);

define('TEXT_NEWSDESK_START_DATE', 'Дата:');
define('TEXT_DATE_FORMAT', 'Формат даты:');

define('TEXT_SHOW_STATUS', 'Статус:');

define('TEXT_DELETE_IMAGE', 'Удалить картинку(и) ?');
define('TEXT_DELETE_IMAGE_INTRO', 'ВНИМАНИЕ: Удаляя картинку, вы удаляете её не только из новостей, но и с диска!!');

define('TEXT_NEWSDESK_STICKY', '"Горячая" новость');
define('TEXT_NEWSDESK_STICKY_ON', 'Да');
define('TEXT_NEWSDESK_STICKY_OFF', 'Нет');
define('TABLE_HEADING_STICKY', '"Горячая" новость');

define('TEXT_NEWSDESK_IMAGE', 'Картинки:');

define('TEXT_NEWSDESK_IMAGE_ONE', 'Первая картинка:');
define('TEXT_NEWSDESK_IMAGE_TWO', 'Вторая картинка:');
define('TEXT_NEWSDESK_IMAGE_THREE', 'Третья картинка:');

define('TEXT_NEWSDESK_IMAGE_SUBTITLE', 'Укажите название первой картинки:');
define('TEXT_NEWSDESK_IMAGE_SUBTITLE_TWO', 'Укажите название второй картинки:');
define('TEXT_NEWSDESK_IMAGE_SUBTITLE_THREE', 'Укажите название третьей картинки:');

define('TEXT_NEWSDESK_IMAGE_PREVIEW_ONE', 'Первая картинка:');
define('TEXT_NEWSDESK_IMAGE_PREVIEW_TWO', 'Вторая картинка:');
define('TEXT_NEWSDESK_IMAGE_PREVIEW_THREE', 'Третья картинка:');

define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Переместить:');

define('TEXT_PRODUCTS_IMAGE_REMOVE_SHORT', 'Удалить картинку, оставив файл картинки на сервере');
define('TEXT_PRODUCTS_IMAGE_DELETE_SHORT', 'Удалить картинку вместе с файлом');

define('TEXT_NEWSDESK_ENABLE', '1 = Активна.');
define('TEXT_NEWSDESK_DISABLE', '0 = Неактивна.');

define('TEXT_NEWSDESK_DATA', 'Данные');
define('TEXT_NEWSDESK_IMAGES', 'Картинки');

?>
<?php
/*
  $Id: products_multi.php, v 2.0

  autor: sr, 2003-07-31 / sr@ibis-project.de

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Мульти-Менеджер');
define('HEADING_TITLE_SEARCH', 'Поиск:');
define('HEADING_TITLE_GOTO', 'Переход:');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_CHOOSE', 'Выберите');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Категории / Продукты');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Код');
define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_PRODUCTS_QUANTITY', 'Кол-во');
define('TABLE_HEADING_MANUFACTURERS_NAME', 'Производитель');
define('TABLE_HEADING_STATUS', 'Статус');

define('DEL_DELETE', 'удалить продукт');
define('DEL_CHOOSE_DELETE_ART', 'Как удалить?');
define('DEL_THIS_CAT', 'только в этой категории');
define('DEL_COMPLETE', 'полностью удалить товар');

define('TEXT_NEW_PRODUCT', 'Новый товар в &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Категории:');
define('TEXT_ATTENTION_DANGER', '');
/*
define('TEXT_ATTENTION_DANGER', '<br><br><span class="dataTableContentRedAlert">!!! Внимание !!! пожалуйста прочтите !!!</span><br><br><span class="dataTableContentRed">Этот инструмент меняет таблицы "products_to_categories" (и в случае  \' полностью удалить товар\' даже "products" и "products_description" among others; через функцию \'tep_remove_product\') - поэтому делать резервную копию этих таблиц перед каждым использованием этого инструмента ОЧЕНЬ рекомендуется. Причины:<br><br>This tool deletes, moves or copies all via checkbox selected products without any interim step or warning, that means immediately after clicking on the go-button.</span><br><br><span class="dataTableContentRedAlert">Please take care:</span><ul><li>Pay very great attention when using <strong>\'delete the complete product\'</strong>. This function deletes all selected products immediately, without interim step or warning, and completely from all tables where these products belong to.</strong></li><li>While choosing <strong>\'delete product only in this category\'</strong>, no products are deleted completely, but only their links to the actually opened category - even when it\'s the only category-link of the product, and without warning, that means: be careful with this delete tool as well.</li><li>While <strong>copying</strong>, products are not duplicated, they are only linked to the new category chosen.</li><li>Products are only <strong>moved</strong> resp. <strong>copied</strong> to a new category in case they do not exist there allready.</li></ul>');
*/
define('TEXT_MOVE_TO', 'переместить в');
define('TEXT_CHOOSE_ALL', 'отметить все');
define('TEXT_CHOOSE_ALL_REMOVE', 'снять отметку');
define('TEXT_SUBCATEGORIES', 'Подкатегории:');
define('TEXT_PRODUCTS', 'Товары:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Цена:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Класс налогов:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Ср.Оценка:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Кол-во:');
define('TEXT_DATE_ADDED', 'Добавлен:');
define('TEXT_DATE_AVAILABLE', 'Наличие:');
define('TEXT_LAST_MODIFIED', 'Изменение:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Пожалуйств, вставьте новую категорию или товар в <br>&nbsp;<br><b>%s</b>');
define('TEXT_PRODUCT_MORE_INFORMATION', 'Посетите <a href="http://%s" target="blank"><u>страницу</u></a> этого товара для получения информации.');
define('TEXT_PRODUCT_DATE_ADDED', 'Этот товар был добавлен в наш каталог %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Этот товар будет в наличии %s.');

define('TEXT_EDIT_INTRO', 'Пожалуйста, сделайте необходимые изменения');
define('TEXT_EDIT_CATEGORIES_ID', 'ID:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Имя:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Изображение:');
define('TEXT_EDIT_SORT_ORDER', 'Сортировка:');

define('TEXT_INFO_COPY_TO_INTRO', 'Пожалуйста, выберите новую категорию, в которую вы хотите скопировать товар');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Существующие категории:');

define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Новая категория');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Изменить категорию');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Удалить категорию');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Переместить категорию');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Удалить товар');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Переместить товар');
define('TEXT_INFO_HEADING_COPY_TO', 'Копировать в');
define('LINK_TO', 'Ссылка на');

define('TEXT_DELETE_CATEGORY_INTRO', 'Вы уверены, что хотите удалить эту категорию?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Вы уверены, что вы хотите навсегда удалить этот товар?');

define('TEXT_DELETE_WARNING_CHILDS', '<b>ВНИМАНИЕ:</b> %s подкатегорий всё ещё связаны с этой категорией!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>ВНИМАНИЕ:</b> %s товаров всё ещё связаны с этой категорией!');

define('TEXT_MOVE_PRODUCTS_INTRO', 'Пожалуйста, выберите категорию, в которую вы хотите поместить <b>%s</b>');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Пожалуйста, выберите категорию, в которую вы хотите поместить <b>%s</b>');
define('TEXT_MOVE', 'Переместить <b>%s</b> в:');

define('TEXT_NEW_CATEGORY_INTRO', 'Пожалуйста, заполните следующие данные для новой категории');
define('TEXT_CATEGORIES_NAME', 'Имя:');
define('TEXT_CATEGORIES_IMAGE', 'Изображение:');
define('TEXT_SORT_ORDER', 'Сортировка:');

define('TEXT_PRODUCTS_STATUS', 'Статус:');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'В наличии:');
define('TEXT_PRODUCT_AVAILABLE', 'В наличии');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Нет в наличии');
define('TEXT_PRODUCTS_MANUFACTURER', 'Производитель:');
define('TEXT_PRODUCTS_NAME', 'Название:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Описание:');
define('TEXT_PRODUCTS_QUANTITY', 'Количество:');
define('TEXT_PRODUCTS_MODEL', 'Кода:');
define('TEXT_PRODUCTS_IMAGE', 'Изображение:');
define('TEXT_PRODUCTS_URL', 'URL:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(без http://)</small>');
define('TEXT_PRODUCTS_PRICE', 'Цена:');
define('TEXT_PRODUCTS_WEIGHT', 'Вес:');
define('TEXT_NONE', '--нет--');

define('EMPTY_CATEGORY', 'Пустая категория');

define('TEXT_HOW_TO_COPY', 'Метод копирования:');
define('TEXT_COPY_AS_LINK', 'Ссылка на товар');
define('TEXT_COPY_AS_DUPLICATE', 'Дублировать товар');

define('TEXT_GO', 'Завершить действие');
define('TEXT_MODEL', 'Код товара');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Ошибка: Не могу сделать ссылку на товар в той же категории.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Ошибка: Папка изображений не доступна для записи: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Ошибка: Папка изображений не существует: ' . DIR_FS_CATALOG_IMAGES);
?>

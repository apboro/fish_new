<?php
/*
	Полный модуль доставки почтой России.
	Filename: modules/shipping/russianpostprepay.php
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	Написано Igel'ем.
	WWW:  http://igel.pp.ru/oscommerce/russianpost/
	MAIL: igel@weblight.us
	ICQ: 9006615
	06.11.2006.
	v.1.02 [24.11.2006]
	Modification: xtCommerce

   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------

*/

	class russianpost{
		var $code, $title, $description, $enabled, $settings;


		function all_settings()
		{
			/* Запросим все настройки нашего модуля*/
            if(sizeof($this->settings) <= 1)
            {
				$sql = tep_db_query("SELECT configuration_key, configuration_value FROM " . TABLE_CONFIGURATION . "
				WHERE configuration_key LIKE '%\_RP\_%'");

				while($config_rows = tep_db_fetch_array($sql))
				{
	            	$crow[] = $config_rows['configuration_key'];
				}

				$this->settings = $crow;
			}
		}

		function is_wrapper($products)
		{
 			/* Узнаем посылка или бандероль */
 			$wrapper = 1;
      		foreach($products as $prod)
			{
				$signal_num = strpos($prod['model'], MODULE_SHIPPING_RP_WRAPPER_SEPARATOR);

				if ($signal_num === false)
				{
					$wrapper = 0;
					break;
				}

				$signal_table = constant('MODULE_SHIPPING_RP_WRAPPER_ISSET');
				$signals = preg_split("/[,]/", $signal_table);
				if (!in_array(substr($prod['model'],0, $signal_num), $signals))
				{
					$wrapper = 0;
					break;
				}
			}
 			/*************/

 			return $wrapper;
		}

		function _install($module)
		{
			$this->all_settings();



			$zones = array(
				array(
						'Брянская область,Владимирская область,Воронежская область,Ивановская область,Калужская область,Костромская область,Курская область,Липецкая область,Москва,Московская область,Нижегородская область,Орловская область,Рязанская область,Смоленская область,Тамбовская область,Тверская область,Тульская область',
						'0.5:111,1:119,1.5:128,2:136,2.5:145,3:153,3.5:162,4:170,4.5:179,5:187,5.5:196,6:204,6.5:213,7:221,7.5:230,8:238,8.5:247,9:255,9.5:264,10:272',
					),
				array(
						'Адыгея республика,Архангельская область,Астраханская область,Башкортостан республика,Белгородская область,Волгоградская область,Вологодская область,Ингушетия республика,Кабардино-Балкарская республика,Карачаево-Черкесская республика,Калининградская область,Калмыкия республика,Карелия республика,Кировская область,Коми республика,Краснодарский край,Ленинградская область,Санкт-Петербург,Марий Эл республика,Мордовия республика,Мурманская область,Новгородская область,Оренбургская область,Псковская область,Пензенская область,Пермский край,Ростовская область,Самарская область,Саратовская область,Свердловская область,Северная Осетия-Алания республика,Ставропольский край,Татарстан республика,Удмуртская республика,Ульяновская область,Челябинская область,Чеченская республика,Чувашская республика,Ярославская область',
						'0.5:112,1:122,1.5:132,2:142,2.5:151,3:161,3.5:171,4:181,4.5:191,5:200,5.5:210,6:220,6.5:230,7:240,7.5:249,8:259,8.5:269,9:279,9.5:289,10:298',
					 ),
				array(
						'Алтай республика,Алтайский край,Дагестан республика,Кемеровская область,Красноярский край,Курганская область,Новосибирская область,Омская область,Томская область,Тыва республика,Тюменская область,Хакасия республика',
						'0.5:117,1:131,1.5:146,2:160,2.5:174,3:189,3.5:203,4:218,4.5:232,5:246,5.5:261,6:275,6.5:290,7:304,7.5:318,8:333,8.5:347,9:362,9.5:376,10:390',
					 ),
				array(
						'Амурская область,Бурятия республика,Иркутская область,Забайкальский край',
						'0.5:142,1:163,1.5:184,2:205,2.5:225,3:246,3.5:267,4:287,4.5:308,5:329,5.5:349,6:370,6.5:391,7:412,7.5:432,8:453,8.5:474,9:494,9.5:515,10:536',
					 ),
				array(
						'Еврейская автономная область,Камчатский край,Магаданская область,Приморский край,Сахалинская область,Хабаровский край,Чукотский автономный округ,Саха (Якутия) республика',
						'0.5:161,1:184,1.5:208,2:232,2.5:256,3:280,3.5:303,4:327,4.5:351,5:375,5.5:399,6:422,6.5:446,7:470,7.5:494,8:518,8.5:541,9:565,9.5:589,10:613',
					 ),
			);

			$countries = array(
				array(
						'BY,EE,UZ',
						'0.1:28,0.25:44,0.5:71,1:112,2:150'
					 ),

				array(
						'*',
						'0.1:62,0.25:87,0.5:131,1:194,2:257'
					 ),
			);




			//таблица старого типа - туда не влезут все наши настроки
			//поэтому таблицу надо расширить (сделать тип поля TEXT)
			$sql = tep_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " LIMIT 1");
			$meta = tep_db_fetch_fields($sql);
			if($meta->blob == 0)
			{
				//tep_db_query("ALTER TABLE `" . TABLE_CONFIGURATION . "` CHANGE `configuration_value` `configuration_value` TEXT NOT NULL");
				//нафига? tep_db_query("ALTER TABLE `" . TABLE_CONFIGURATION . "` CHANGE `configuration_title` `configuration_title` VARCHAR( 128 ) NOT NULL");
			}

			/*
			нафига?
			$sql = tep_db_query("SELECT configuration_description FROM " . TABLE_CONFIGURATION . " LIMIT 1");

			$meta = tep_db_fetch_fields($sql);
			if($meta->blob == 0)
			{
            	tep_db_query("ALTER TABLE `" . TABLE_CONFIGURATION . "` CHANGE `configuration_description` `configuration_description` TEXT NOT NULL");
			}
			*/



			/********** НАЛОЖКА **********
			*
			*
			******************************/
			if($module != 'prepay')
			{
				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Разрешить наложенный платёж ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_PARCEL_STATUS_PF', 'True', 'Вы хотите активировать &laquo;наложку&raquo; для ПОСЫЛКИ?', '6', '15', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Разрешить наложенный платёж БАНДЕРОЛИ.', 'MODULE_SHIPPING_RP_WRAPPER_STATUS_PF', 'True', 'Вы хотите активировать &laquo;наложку&raquo; для БАНДЕРОЛИ?', '6', '18', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");

				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Сортировать', 'MODULE_SHIPPING_RP_SORT_ORDER_PF', '9', 'Положение этого модуля в списке модулей.', '6', '24', now())");

				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Почта России (&laquo;наложка&raquo;) - Tax Class', 'MODULE_SHIPPING_RP_TAX_CLASS_PF', '0', 'Use the following tax class on the shipping fee.', '6', '21', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");

				//расходы магазина на наложку
		 		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Расходы магазина на &laquo;наложку&raquo; за ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_PARCEL_COST', '0', 'Zx% - некий процент от стоимости заказа; x - фиксированная стоимость. x - какое-либо число, Z режим: <b>p</b> - процент от стоимости товара, <b>d</b> - процент от стоимости доставки (с учётом суммы за сборку), <b>a (или отсутствие буквы)</b> - процент от стоимости товара и доставки. <br><i>Указанная сумма (процент) прибавится к стоимости доставки.</i>', '6', '74', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,  configuration_group_id, sort_order, date_added) values ('Расходы магазина на &laquo;наложку&raquo; за БАНДЕРОЛИ.', 'MODULE_SHIPPING_RP_WRAPPER_COST', '0', 'Zx% - некий процент от стоимости заказа; x - фиксированная стоимость. x - какое-либо число, Z режим: <b>p</b> - процент от стоимости товара, <b>d</b> - процент от стоимости доставки (с учётом суммы за сборку), <b>a (или отсутствие буквы)</b> - процент от стоимости товара и доставки. <br><i>Указанная сумма (процент) прибавится к стоимости доставки.</i>', '6', '77', now())");

			 	//ограничение регионов для наложки
				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,  configuration_group_id, sort_order, date_added) values ('Регионы, в которые ПОСЫЛКИ &laquo;наложкой&raquo; не доставляются.', 'MODULE_SHIPPING_RP_PARCEL_LIMITATION_PF', '0', 'Несколько регионов можно указать через запятую.', '6', '83', now())");
				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,  configuration_group_id, sort_order, date_added) values ('Регионы, в которые БАНДЕРОЛИ &laquo;наложкой&raquo; не доставляются.', 'MODULE_SHIPPING_RP_WRAPPER_LIMITATION_PF', '0', 'Несколько регионов можно указать через запятую.', '6', '86', now())");

			}


			/********* ПРЕДОПЛАТА *********
			*
			*
			******************************/
			if($module == 'prepay')
			{
				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Разрешить наложенный платёж ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_PARCEL_STATUS', 'True', 'Вы хотите активировать &laquo;наложку&raquo; для ПОСЫЛКИ?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Разрешить наложенный платёж БАНДЕРОЛИ.', 'MODULE_SHIPPING_RP_WRAPPER_STATUS', 'True', 'Вы хотите активировать &laquo;наложку&raquo; для БАНДЕРОЛИ?', '6', '6', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");

			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Почта России (&laquo;наложка&raquo;) - Tax Class', 'MODULE_SHIPPING_RP_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '21', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");

				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Сортировать', 'MODULE_SHIPPING_RP_SORT_ORDER_PREPAY', '7', 'Положение этого модуля в списке модулей.', '6', '24', now())");

				//страны первого уровня - Беларусь, Узбекистан, Эстония
		   		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,
				configuration_group_id, sort_order, date_added) values ('*Страны первого уровня (Беларусь, Узбекистан, Эстония)', 
				'MODULE_SHIPPING_RP_COUNTRY_1', '" . $countries[0][0]  ."', 'Введите КОДЫ (ISO 2) стран первого уровня (Беларусь, Узбекистан, Эстония).', '6', '50', now())");

			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Страны первого уровня: таблица стоимости', 'MODULE_SHIPPING_RP_COUNTRY_PRICE_1', '" . $countries[0][1]  ." ',  'По шаблону: <i>вес:цена,вес:цена</i>. Пример 3:8.50,7:10.50,... и т.д.', '6', '53', now())");

				//остальные страны
		   		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,
				configuration_group_id, sort_order, date_added) values ('*Остальные страны', 
				'MODULE_SHIPPING_RP_COUNTRY_2', '" . $countries[1][0]  ."', 'Введите КОДЫ (ISO 2) остальных стран. Если Вы готовы доставлять по всему миру, то введите * (звёздочку), иначе вводите коды.', '6', '56', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Остальные страны: таблица стоимости', 'MODULE_SHIPPING_RP_COUNTRY_PRICE_2', '" . $countries[1][1]  ." ', 'По шаблону: <i>вес:цена,вес:цена</i>. Пример 3:8.50,7:10.50,... и т.д.', '6', '59', now())");

				//оценочная сумма
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Сумма оценочной стоимости ПОСЫЛКИ (без НП).', 'MODULE_SHIPPING_RP_PARCEL_INSURANCE_PRICE', '0', '0 - сумма оценки будет равна стоимости заказа с доставкой; x% - некий процент от стоимости заказа; x - фиксированная стоимость. x - какое-либо число', '6', '68', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Сумма оценочной стоимости БАНДЕРОЛИ (без НП).', 'MODULE_SHIPPING_RP_WRAPPER_INSURANCE_PRICE', '0', '0 - сумма оценки будет равна стоимости заказа с доставкой; x% - некий процент от стоимости заказа; x - фиксированная стоимость. x - какое-либо число', '6', '71', now())");



		 		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Стоимость оформления МЕЖДУНАРОДНОЙ ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_INTER_REG', '0', 'Укажите сумму', '6', '85', now())");

			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Максимальный вес одной МЕЖДУНАРОДНОЙ ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_INTER_MAXWEIGHT', '10', 'Какой максимальный вес может быть у посылки? Если вес будет больше, заказ будет разбит на несколько посылок.', '6', '65', now())");

				//бесплатная доставка
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Сумма для бесплатной доставки ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_PARCEL_FREE', '0', 'Укажите сумму, при которой доставка будет бесплатной. Если указать 0, то бесплатной доставки не будет.', '6', '86', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Сумма для бесплатной доставки БАНДЕРОЛИ.', 'MODULE_SHIPPING_RP_WRAPPER_FREE', '0', 'Укажите сумму, при которой доставка будет бесплатной. Если указать 0, то бесплатной доставки не будет.', '6', '89', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Сумма для бесплатной доставки МЕЖДУНАРОДНОЙ ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_INTER_FREE', '0', 'Укажите сумму, при которой доставка в ДРУГИЕ СТРАНЫ будет бесплатной. Если указать 0, то бесплатной доставки не будет.', '6', '92', now())");

			}


            //установка свежего модуля
			if(
			   !@in_array(MODULE_SHIPPING_RP_PARCEL_STATUS , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_WRAPPER_STATUS , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_PARCEL_STATUS_PF , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_WRAPPER_STATUS_PF , $this->settings)
			   )
			{

				//вычисление бандероли
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('*Разделитель модели (артикула) товара и &laquo;ключа&raquo; бандероли.', 'MODULE_SHIPPING_RP_WRAPPER_SEPARATOR', '-', 'Необходимо указать, каким символом будет отделяться модель (артикул) товара от метки бандероли. Например: <i><font color=#008080>banderol</font><b>-</b><font color=#800040>ART6789B</font></i>', '6', '9', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('*Сигнальная часть для вычисления БАНДЕРОЛИ.', 'MODULE_SHIPPING_RP_WRAPPER_ISSET', 'bn,book', 'Вы можете ввести несколько сигнальных частей через запятую.', '6', '12', now())");


       	     //внутренние зоны
      	      $g = 0;
     	       for($i=1; $i<=5; $i++)
    	        {
  		          	$k = $i -1;
	   				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,configuration_group_id, sort_order,
	   				date_added) values ('" . $i ."-я зона',
					'MODULE_SHIPPING_RP_STATES_" . $i ."', '" . $zones[$k][0] . "', 'Введите название областей РФ для " . $i ."-й зоны.', '6', '".(27+$g)."', now())");

			        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $i ."-я зона: таблица стоимости ПОСЫЛКИ', 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_" . $i ."', '" . $zones[$k][1]  ."', 'По шаблону: <i>вес:цена,вес:цена</i>. Пример 3:8.50,7:10.50,... и т.д.', '6', '".(27+$g+1)."',  now())");
			        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $i ."-я зона: таблица стоимости БАНДЕРОЛИ', 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_" . $i ."', '" . $zones[$k][2]  ."', 'По шаблону: <i>вес:цена,вес:цена</i>. Пример 3:8.50,7:10.50,... и т.д.', '6', '".(27+$g+2)."',  now())");
			        $g = $g+3;
	            }

		 		//страховые проценты
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('*Проценты, взимаемые почтой за оценочную стоимость ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_PARCEL_INSURANCE', '4', 'Введите только цифры', '6', '62', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('*Проценты, взимаемые почтой за оценочную стоимость БАНДЕРОЛИ.', 'MODULE_SHIPPING_RP_WRAPPER_INSURANCE', '3', 'Введите только цифры', '6', '65', now())");

			 	//максимальный вес
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('*Максимальный вес одной БАНДЕРОЛИ.', 'MODULE_SHIPPING_RP_WRAPPER_MAXWEIGHT', '2', 'Какой максимальный вес может быть у бандероли? Если вес будет больше, будет выбрана посылка или заказ будет разбит на несколько бандеролей.', '6', '65', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('*Максимальный вес одной ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_PARCEL_MAXWEIGHT', '10', 'Какой максимальный вес может быть у посылки? Если вес будет больше, заказ будет разбит на несколько посылок.', '6', '65', now())");
			 	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('*Разбивать &laquo;тяжеловесные&raquo; бандероли на несколько штук (иначе использовать посылку)?', 'MODULE_SHIPPING_RP_WRAPPERS_OR_PARCEL', 'True', '<b>Да</b> - разбиение на несколько бандеролей.<br><b>Нет</b> - переход в разряд посылок.', '6', '6', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");


				//стоимость оформления почтового отправления
				tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('*Стоимость оформления ПОСЫЛКИ.', 'MODULE_SHIPPING_RP_PARCEL_REG', '0','Укажите сумму','6', '80', now())");
		 		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('*Стоимость оформления БАНДЕРОЛИ.','MODULE_SHIPPING_RP_WRAPPER_REG', '0','Укажите сумму','6', '83', now())");

		 	}
	    }


		function _remove($module)
		{

            $this->all_settings();
			/********** НАЛОЖКА **********
			*
			*
			******************************/
			if($module != 'prepay' &&
			   !@in_array(MODULE_SHIPPING_RP_PARCEL_STATUS , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_WRAPPER_STATUS , $this->settings)
			   )
            		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key IN ('" . implode("', '", $this->_keys('all')) . "')");




			/********* ПРЕДОПЛАТА *********
			*
			*
			******************************/
			if($module == 'prepay' &&
			   !@in_array(MODULE_SHIPPING_RP_PARCEL_STATUS_PF , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_WRAPPER_STATUS_PF , $this->settings)
			   )
            		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key IN ('" . implode("', '", $this->_keys('all')) . "')");


			tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key IN ('" . implode("', '", $this->_keys($module)) . "')");
		}


		function _keys($module, $act='')
		{
			//обычная
			$Pkeys = array(
			0 => 'MODULE_SHIPPING_RP_PARCEL_STATUS',//вкл./выкл. ПОСЫЛКУ - 1
			3 => 'MODULE_SHIPPING_RP_WRAPPER_STATUS', //вкл./выкл. БАНДЕРОЛЬ - 1

			6 => 'MODULE_SHIPPING_RP_TAX_CLASS',//налог

			9 => 'MODULE_SHIPPING_RP_SORT_ORDER_PREPAY',//сортировка - 3

			45 => 'MODULE_SHIPPING_RP_COUNTRY_1',//коды стран "первого уровня" (Белоруссия, Узбекистан, Эстония)
			48 => 'MODULE_SHIPPING_RP_COUNTRY_2',//Коды остальных стран (* - любая страна) - *

			46 => 'MODULE_SHIPPING_RP_COUNTRY_PRICE_1',//цены для стран "первого уровня" (Белоруссия, Узбекистан, Эстония)
			49 => 'MODULE_SHIPPING_RP_COUNTRY_PRICE_2',//цены для остальных стран (* - любая страна) - *

			55 => 'MODULE_SHIPPING_RP_PARCEL_INSURANCE_PRICE',//оценочная стоимость: 0=стоимость заказа с доставкой;
			58 => 'MODULE_SHIPPING_RP_WRAPPER_INSURANCE_PRICE',//оценочная стоимость: 0=стоимость заказа с доставкой;

			73 => 'MODULE_SHIPPING_RP_INTER_REG',//цена за оформление международной посылки

			77 => 'MODULE_SHIPPING_RP_INTER_MAXWEIGHT',//максимальный вес международной посылки

			80 => 'MODULE_SHIPPING_RP_PARCEL_FREE',//сумма, при которой доставка ПОСЫЛКОЙ бесплатна - 0
			83 => 'MODULE_SHIPPING_RP_WRAPPER_FREE',//сумма, при которой доставка БАНДЕРОЛЬЮ бесплатна - 0
			87 => 'MODULE_SHIPPING_RP_INTER_FREE',//сумма, при которой международная доставка бесплатна

			);

            //наложка
			$PFkeys = array(
			0 => 'MODULE_SHIPPING_RP_PARCEL_STATUS_PF',//вкл./выкл. наложку ПОСЫЛКИ - 1
			3 => 'MODULE_SHIPPING_RP_WRAPPER_STATUS_PF',//вкл./выкл. наложку БАНДЕРОЛИ - 1

			9 => 'MODULE_SHIPPING_RP_SORT_ORDER_PF',//сортировка - 3

			6 => 'MODULE_SHIPPING_RP_TAX_CLASS_PF',//налог

			80 => 'MODULE_SHIPPING_RP_PARCEL_COST',//процент или сумма за наложку (типа "расходы" магазина из-за "зависания денег") ПОСЫЛКИ - 0
			83 => 'MODULE_SHIPPING_RP_WRAPPER_COST',//процент или сумма за наложку (типа "расходы" магазина из-за "зависания денег") БАНДЕРОЛИ - 0

			86 => 'MODULE_SHIPPING_RP_PARCEL_LIMITATION_PF',//регионы, в которые нельзя отправлять ПОСЫЛКИ наложкой
			87 => 'MODULE_SHIPPING_RP_WRAPPER_LIMITATION_PF',//регионы, в которые нельзя отправлять БАНДЕРОЛИ наложкой

			);


			$ALLkeys = array(

			12 => 'MODULE_SHIPPING_RP_WRAPPER_SEPARATOR',//по какой строке искать бандероль - -
			15=> 'MODULE_SHIPPING_RP_WRAPPER_ISSET',//сигнальная часть модели (артикула) - band

			27 => 'MODULE_SHIPPING_RP_STATES_1',//Первая зона
			30 => 'MODULE_SHIPPING_RP_STATES_2',//Вторая зона
			34 => 'MODULE_SHIPPING_RP_STATES_3',//Третья зона
			37 => 'MODULE_SHIPPING_RP_STATES_4',//Четвертая зона
			40 => 'MODULE_SHIPPING_RP_STATES_5',//Пятая зона

			//стоимость бандероли
			28 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_1',//Первая цена
			31 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_2',//Вторая цена
			35 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_3',//Третья цена
			38 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_4',//Четвертая цена
			41 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_5',//Пятая цена

			//стоимость посылки
			29 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_1',//Первая цена
			32 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_2',//Вторая цена
			36 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_3',//Третья цена
			39 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_4',//Четвертая цена
			42 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_5',//Пятая цена

			61 => 'MODULE_SHIPPING_RP_PARCEL_INSURANCE',//страховой процент взимаемый почтой за ПОСЫЛКУ - 3
			64 => 'MODULE_SHIPPING_RP_WRAPPER_INSURANCE',//страховой процент взимаемый почтой за БАНДЕРОЛЬ - 3

			67 => 'MODULE_SHIPPING_RP_PARCEL_REG',//цена за оформление ПОСЫЛКИ
			70 => 'MODULE_SHIPPING_RP_WRAPPER_REG',//цена за оформление БАНДЕРОЛИ

			75 => 'MODULE_SHIPPING_RP_WRAPPER_MAXWEIGHT',//макисмальный вес бандероли
			76 => 'MODULE_SHIPPING_RP_PARCEL_MAXWEIGHT',//макисмальный вес бандероли


			78 => 'MODULE_SHIPPING_RP_WRAPPERS_OR_PARCEL',//при перевесе использовать разбивку на несколько бандеролей или переходить в посылки
			);

			//наложка
			if($module!='prepay')$key = $PFkeys;

			//предоплата
			if($module=='prepay')$key = $Pkeys;

			//общее
			if($module=='all')$key = $ALLkeys;


			if($act == 'all')
			{
				//$key = array_merge($key , $ALLkeys);
				foreach($ALLkeys as $k=>$v)
				{
					$key[$k] = $v;
				}
			}

			ksort($key);
			foreach($key as $k=>$v)
			{
				$key2[] = $v;
			}

			return $key2;
		}

		//функция обработки числительных
		function om_number($number, $titles)
		{
		        $cases = array (2, 0, 1, 1, 1, 2);
		    return $number." ".$titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
		}


		//стоимость доаставки
		//$cost_table - array('цена', 'вес','цена', 'вес');
		//$weight - вес
		//$need_parcel - необходимое кол-во посылок
		//$maxweight - максимальный вес посылки
		//$reg - стоимость сбора одной посылки
		function price($cost_table, $weight, $need_parcel, $maxweight, $reg)
		{
			//максимальный вес первой посылки
			$shipping = 0;
			if($need_parcel > 1)
			{
				$first = $maxweight;
	      		for ($i=0; $i<sizeof($cost_table); $i+=2)
	        	{
	         		if ($first <= $cost_table[$i])
	          		{
	         		 	$shipping = $cost_table[$i+1]+$reg;
	     		        break;
					}
				}

				$shipping = $shipping*($need_parcel-1);

				$final = $weight-($maxweight*($need_parcel-1));

			}
			else $final = $weight;

	  		for ($i=0; $i<sizeof($cost_table); $i+=2)
	    	{
	     		if ($final <= $cost_table[$i])
	       		{
	         		$shipping = $shipping + $cost_table[$i+1]+$reg;
	     		    break;
				}
			}

			return $shipping;
		}


		//подсчитываем сумму, которую придётся отдать почте за
		//оценочную стоимость.
		//$price - сумма
		//4rate - процент
		function insurance($price, $rate)
		{
			if($rate==0)return 0;

			$x = 100-$rate;
            $y = ($price/$x)*100;
			return $y-$price;
		}

	}


	class russianpostprepay extends  russianpost{
		var $code, $title, $description, $enabled;

		function russianpostprepay()
		{
		      $this->code = 'russianpostprepay';
		      $this->title = MODULE_SHIPPING_RP_TEXT_TITLE_PREPAY;
		      $this->description = MODULE_SHIPPING_RP_TEXT_DESCRIPTION_PREPAY;
		      $this->sort_order = MODULE_SHIPPING_RP_SORT_ORDER_PREPAY;
		      $this->icon = DIR_WS_ICONS . 'russianpost.png';
		      $this->tax_class = MODULE_SHIPPING_RP_TAX_CLASS;
		      $this->enabled = ((MODULE_SHIPPING_RP_PARCEL_STATUS == 'True' || MODULE_SHIPPING_RP_WRAPPER_STATUS == 'True') ? true : false);
		}


		function check()
		{
			if (!isset($this->_check))
			{
				$check_query = tep_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_SHIPPING_RP_PARCEL_STATUS' || configuration_key = 'MODULE_SHIPPING_RP_WRAPPER_STATUS' LIMIT 1");
				$this->_check = tep_db_num_rows($check_query);
			}
			return $this->_check;
		}



		// class methods
    	function quote($method = '')
    	{
			global $order, $shipping_weight, $currencies, $cart;

   			$home = false;

			$dest_country = $order->delivery['country']['iso_code_2'];
			$dest_province = $order->delivery['state'];
			$dest_zone_id;


			//Если страна Россия, то цену смотрим по региону
			//"домашняя" страна.
			if($dest_country == "RU")
			{
				$dest_zone_id = $dest_province;
				$home = true;
			}

			//Если страна другая, то цену смотрим
			//исходя из страны.
			else $dest_zone_id = $dest_country;

			$dest_zone = 0;
			$error = false;
			$err_msg;

			//смотрим нужный регион
			if($home)
			{
				for ($i=1; $i<=5; $i++)
				{
					$zones_table = constant('MODULE_SHIPPING_RP_STATES_' . $i);
					$zones = preg_split("/[,]/", $zones_table);
					if (in_array($dest_zone_id, $zones))
					{
						$dest_zone = $i;
						break;
					}
				}
			}

			//смотрим нужную страну
			else
			{
				$zones_table = constant('MODULE_SHIPPING_RP_COUNTRY_1');
				$zones = preg_split("/[,]/", $zones_table);
				if (in_array($dest_zone_id, $zones))$dest_zone = 21;

				//тогда ищем в странах второго уровня
				else
				{
					$zones_table = constant('MODULE_SHIPPING_RP_COUNTRY_2');
					$zones = preg_split("/[,]/", $zones_table);
					if (in_array($dest_zone_id, $zones) || in_array('*', $zones))$dest_zone = 22;
				}
			}

			//узнаем посылка или бандероль
			//вес заказа меньше максимального для бандероли
			$need_wr = (MODULE_SHIPPING_RP_WRAPPER_MAXWEIGHT < $shipping_weight) ? ((MODULE_SHIPPING_RP_WRAPPERS_OR_PARCEL == 'True') ? 1 : 0) : 1;

			//$wrapper = 0 - посылка
			//$wrapper = 1 - бандероль
			$wrapper = (MODULE_SHIPPING_RP_WRAPPER_STATUS == 'True' && $need_wr) ? $this->is_wrapper($cart->get_products())  : 0;

			if($wrapper == 0 && MODULE_SHIPPING_RP_PARCEL_STATUS != 'True')return false;

			$mode = ($wrapper == 1) ? 'WRAPPER' : 'PARCEL';

			//высчитываем на сколько посылок/бандеролей нужно разбить заказ
			$need_parcel = 1;
			$maxweight = constant('MODULE_SHIPPING_RP_'.(($dest_zone < 20) ? $mode : 'INTER').'_MAXWEIGHT');
			if($shipping_weight > $maxweight)
			{
				$need_parcel = ceil($shipping_weight/$maxweight);
			}



      		if ($dest_zone == 0)
	      	{
				$error = true;
				$err_msg = MODULE_SHIPPING_RP_INVALID_ZONE;
			}

			else
			{
				//отправление по России
				if($dest_zone < 20)
				{
					$shipping = -1;
					$zones_cost = constant('MODULE_SHIPPING_RP_STATES_PRICE_'.$mode.'_' . $dest_zone);

					$cost_table = preg_split("/[:,]/" , $zones_cost);

					$shipping = $this->price($cost_table, $shipping_weight, $need_parcel, $maxweight, constant('MODULE_SHIPPING_RP_'.(($dest_zone < 20) ? $mode : 'INTER').'_REG'));

	    			$shipping_method = constant('MODULE_SHIPPING_RP_TEXT_WAY_'.$mode).' <nobr>('.$order->delivery['state'].
	       		     							' - '.$shipping_weight.' '.MODULE_SHIPPING_RP_TEXT_UNITS.'</nobr> <nobr>['.
	       		     							constant('MODULE_SHIPPING_RP_'.$mode.'_NEED').
	       		     							$this->om_number($need_parcel, array(constant('MODULE_SHIPPING_RP_'.$mode.'_1'),
	       		     														constant('MODULE_SHIPPING_RP_'.$mode.'_2'),
	       		     														constant('MODULE_SHIPPING_RP_'.$mode.'_5'))).
	       		     							']</nobr>)';
				}

				//МЕЖДУНАРОДНОЕ ОТПРАВЛЕНИЕ
				else
				{
					$shipping = -1;
					$zones_cost = constant('MODULE_SHIPPING_RP_COUNTRY_PRICE_' . (($dest_zone == '21') ? 1 : 2));

					$cost_table = preg_split("/[:,]/" , $zones_cost);

					$shipping = $this->price($cost_table, $shipping_weight, $need_parcel, $maxweight, constant('MODULE_SHIPPING_RP_'.(($dest_zone < 20) ? $mode : 'INTER').'_REG'));

   		     		$shipping_method = constant('MODULE_SHIPPING_RP_TEXT_WAY_COUNTRY').' <nobr>('.$order->delivery['country']['title'].
	       		     							' - '.$shipping_weight.' '.MODULE_SHIPPING_RP_TEXT_UNITS.'</nobr> <nobr>['.
	       		     							constant('MODULE_SHIPPING_RP_INTER_NEED').
	       		     							$this->om_number($need_parcel, array(constant('MODULE_SHIPPING_RP_INTER_1'),
	       		     														constant('MODULE_SHIPPING_RP_INTER_2'),
	       		     														constant('MODULE_SHIPPING_RP_INTER_5'))).
	       		     							']</nobr>)';


				}



                if($shipping == 0)$shipping = -1;

				if ($shipping == -1)
				{
					$error = true;
          			$err_msg = MODULE_SHIPPING_RP_UNDEFINED_RATE;
        		}

        		else
        		{

          			/**** Формула подсчёта цены ****/
          			//внутренние отправления
                    if($dest_zone < 20)
                    {
	          			/*-- Оценочная стоимость в настройках --*/
	          			$appraisal = 0;
	          			if(constant('MODULE_SHIPPING_RP_'.$mode.'_INSURANCE_PRICE') != 0)
	          			{
	                    	$appraisal = (strpos(constant('MODULE_SHIPPING_RP_'.$mode.'_INSURANCE_PRICE'), '%') === false ) ?
	                    				constant('MODULE_SHIPPING_RP_'.$mode.'_INSURANCE_PRICE') :
	                    				substr(constant('MODULE_SHIPPING_RP_'.$mode.'_INSURANCE_PRICE'), 0, strpos(constant('MODULE_SHIPPING_RP_'.$mode.'_INSURANCE_PRICE'), '%'));

	                    	$appraisal_proc = (strpos(constant('MODULE_SHIPPING_RP_'.$mode.'_INSURANCE_PRICE'), '%') === false) ? false : true;
	          			}

						$appraisal = intval($appraisal);



						//оценочная стоимость
						if($appraisal > 0)
						{
							//процент от суммы
							if($appraisal_proc)
								$appraisal_price = ($shipping + $cart->show_total() / 100) * $appraisal;
							//фиксированная сумма
							else
								$appraisal_price = $appraisal;

						}
						//фактическая стоимость оценки
						else
							//доставка + сумма заказа
							$appraisal_price = $shipping + $cart->show_total();

						//высчитываем страховую стоимость
						$insurance_price = $this->insurance($appraisal_price, intval(constant('MODULE_SHIPPING_RP_'.$mode.'_INSURANCE')));

	       				//итоговая стоимость доставки = доставка + плата за сбор посылки + страховой процент
						$shipping_cost = $shipping + $insurance_price;


						//БЕСПЛАТНАЯ ДОСТАВКА
						if(intval(constant('MODULE_SHIPPING_RP_'.$mode.'_FREE')) > 0)
						{
							if($cart->show_total() >= intval(constant('MODULE_SHIPPING_RP_'.$mode.'_FREE')))$shipping_cost = 0;
						}
					}

					/* Международные отправления */
					else
					{
						//итоговая стоимость доставки = доставка + плата за сбор посылки
						$shipping_cost = $shipping;

						//БЕСПЛАТНАЯ ДОСТАВКА
						if(intval(constant('MODULE_SHIPPING_RP_INTER_FREE')) > 0)
						{
							if($cart->show_total() >= intval(constant('MODULE_SHIPPING_RP_INTER_FREE')))$shipping_cost = 0;
						}
					}
        		}
      }


      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_RP_TEXT_TITLE_PREPAY,
                            'methods' => array(
                            					array('id' => $this->code,
                                                     'title' => $shipping_method,
                                                     'cost' => ceil($shipping_cost)
                                                     )
                                         	)

                            );




      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      if ($error == true) $this->quotes['error'] = $err_msg;

      return $this->quotes;
    }


    function install()
    {
    	$this->_install('prepay');
    }

    function remove()
    {
    	$this->_remove('prepay');
    }


    function keys()
    {
    	return $this->_keys('prepay', 'all');
    }
  }
?>
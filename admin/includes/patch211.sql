insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SMTP сервер', 'EMAIL_SMTP_SERVER', 'smtp.server.com', 'Укажите smtp сервер, если Вы включили отправку почты через smtp.', '12', '6', NULL, '2003-07-17 10:29:22', NULL, '');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SMTP сервер: Порт', 'EMAIL_SMTP_PORT', '25', 'Установите порт smtp сервера.', '12', '7', NULL, '2003-07-17 10:29:22', NULL, '');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SMTP авторизация', 'EMAIL_SMTP_AUTH', 'false', 'SMTP авторизация.', '12', '8', '2004-02-16 11:51:56', '2003-07-17 10:29:22', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'),');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SMTP сервер: Имя пользователя', 'EMAIL_SMTP_USERNAME', 'username', 'Установите имя пользователя для подключения к серверу.', '12', '9', NULL, '2003-07-17 10:29:22', NULL, '');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SMTP сервер: Пароль', 'EMAIL_SMTP_PASSWORD', 'password', 'Установите пароль для подключения к серверу.', '12', '10', NULL, '2003-07-17 10:29:22', NULL, '');

insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Показывать закладку карта на странице заказа', 'ENABLE_MAP_TAB', 'true', 'Включить/Отключить закладку карта на странице заказа.', '1', '116', '2009-04-24 15:29:10', '2008-07-17 10:29:22', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'),');

insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Яндекс карты API-Ключ', 'MAP_API_KEY', '', 'Укажите Ваш API ключ.', '1', '117', NULL, '2006-01-04 13:42:04', NULL, NULL);

DROP TABLE IF EXISTS email_batch;
CREATE TABLE email_batch (
  id int(5) unsigned NOT NULL auto_increment,
  charset varchar(20) default NULL,
  send char(2) default NULL,
  to_name varchar(50) NOT NULL default '',
  to_address varchar(255) NOT NULL default '',
  subject varchar(100) NOT NULL default '',
  text text NOT NULL,
  from_name varchar(50) default NULL,
  from_address varchar(50) default NULL,
  last_updated datetime default NULL,
  created datetime default NULL,
  hold char(2) default NULL,
  ip varchar(15) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY email_id (id),
  KEY email_id_2 (id),
  KEY send (send),
  KEY hold (hold)
);

DROP TABLE IF EXISTS email_batch_a;
CREATE TABLE email_batch_a (
  id int(5) unsigned NOT NULL default '0',
  charset varchar(20) default NULL,
  send char(2) default NULL,
  to_name varchar(50) NOT NULL default '',
  to_address varchar(255) NOT NULL default '',
  subject varchar(100) NOT NULL default '',
  text text NOT NULL,
  from_name varchar(50) default NULL,
  from_address varchar(50) default NULL,
  last_updated datetime default NULL,
  created datetime default NULL,
  hold char(2) default NULL,
  ip varchar(15) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY email_id (id),
  KEY email_id_2 (id)
);

insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Use Email Queue', 'USE_EMAIL_QUEUE', 'false', 'Process the emails via the Email Queue', '12', '11', '2009-04-24 15:29:10', '2008-07-17 10:29:22', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'),');

insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Hold Email Queue', 'HOLD_EMAIL_QUEUE', 'false', 'Hold all emails in the Email Queue', '12', '12', '2009-04-24 15:29:10', '2008-07-17 10:29:22', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'),');

insert into admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) values ('email_queue.php', '0', '9', '1');
insert into admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) values ('email_batch_send.php', '0', '9', '1');

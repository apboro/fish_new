<?php
/*
  $Id: privacy.php,v 1.3 2001/12/20 14:14:15 dgw_ Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2000,2001 The Exchange Project

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Minimum order amount');
define('HEADING_TITLE', 'Minimum order amount');
define('TEXT_INFORMATION', 'You are '. $currencies->format(-$cart->show_total() - (-MIN_ORDER_B2B)) .' short of the ' . $currencies->format(MIN_ORDER_B2B) . ' minimum order fee!');

?>
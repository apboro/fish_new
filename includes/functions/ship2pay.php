<?php
/*
	$Id: Ship2Pay, v1.5 2005/01/07 00:00:00 gjw Exp $

	osCommerce, Open Source E-Commerce Solutions
	http://www.oscommerce.com

	Copyright (c) 2003 Edwin Bekaert (edwin@ednique.com)

	Released under the GNU General Public License

	http://forums.oscommerce.com/index.php?showtopic=36112

	http://www.oscommerce.com/community/contributions,1042
*/

////
// Function to handle links between shipping and payment

function ship2pay() {
	global $shipping, $order;
	$shipping_module = substr($shipping['id'], 0, strpos($shipping['id'], '_')) . '.php';
	$q_ship2pay = tep_db_query("SELECT payments_allowed, zones_id FROM " . TABLE_SHIP2PAY . " where shipment = '" . $shipping_module . "' and status=1");
	$check_flag = false;
	while($mods = tep_db_fetch_array($q_ship2pay)) {
		if($mods['zones_id'] > 0) {
			$check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . $mods['zones_id'] . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
			while ($check = tep_db_fetch_array($check_query)) {
				if ($check['zone_id'] < 1) {
					$check_flag = true;
					break 2;
				} elseif ($check['zone_id'] == $order->delivery['zone_id']) {
					$check_flag = true;
					break 2;
				}
			}
		} else {
			$check_flag = true;
			break;
		}
	}
	if($check_flag)
		$modules = $mods['payments_allowed'];
	else
		$modules = MODULE_PAYMENT_INSTALLED;
	$modules = explode(';', $modules);
	return($modules);
}
?>

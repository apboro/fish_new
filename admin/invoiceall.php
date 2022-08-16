<?php

require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/invoice.php');
require(DIR_WS_CLASSES . 'currencies.php');
include(DIR_WS_CLASSES . 'order.php');
$currencies = new currencies();
if (!isset($_GET['process']) || (strlen(trim($_GET['orders'])) == 0)) {
    ?>
    <!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html <?php echo HTML_PARAMS; ?> >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
        <title><?php echo TITLE; ?></title>
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
        <script language="javascript" src="includes/menu.js"></script>
        <script language="javascript" src="includes/general.js"></script>
    </head>
    <body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0"
          bgcolor="#FFFFFF" onload="SetFocus();">
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->
    <!-- body //-->
    <table border="0" width="100%" cellspacing="2" cellpadding="2">
        <tr>
            <td width="<?php echo BOX_WIDTH; ?>" valign="top">
                <table border="0" width="<?php echo BOX_WIDTH; ?> " cellspacing="1" cellpadding="1" class="columnLeft">
                    <!-- left_navigation //-->
                    <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
                    <!-- left_navigation_eof //-->
                </table>
            </td>
            <td valign="top">
                <!-- body_text -->
                <form target="_blank" method="GET" action="/admin/<?php echo basename(__FILE__); ?>">
                    <input type="hidden" name="process" value="1">
                    <span>Номера заказов через пробел</span><br>
                    <input name="orders" value="" size="80"><br>
                    <input type="submit" value="Распечатать">
                </form>
<?php
$search = array('-', ')', '(', ' ');
  $tel = str_replace($search, "", explode(",", $_POST['telefons']));
  $data_massa = array(
     "data" => array(
     "addresses"   => $tel,
    "message" => $_POST['smstext'],
    "target_device_iden" => "ujCebCmJMyWsjv9KNd3kGa"
));
				
function sendSMS($data){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.pushbullet.com/v2/texts");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=cp1251", "Access-Token: o.JNYdz8BzzY9PrV40KVQGdfHeUx0IRBr3",));
$html = curl_exec($ch);
curl_close($ch); 
}
?>

				
				

                <!-- body_text_eof //-->
            </td>
        </tr>
    </table>
    <!-- body_eof //-->

    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
    <br>
    </body>
    </html>

    <?php
    exit;
}


class inwords
{

    var $diw = Array(0 => Array(0 => Array(0 => text_zero, 1 => 1),
        1 => Array(0 => "", 1 => 2),
        2 => Array(0 => "", 1 => 3),
        3 => Array(0 => text_three, 1 => 0),
        4 => Array(0 => text_four, 1 => 0),
        5 => Array(0 => text_five, 1 => 1),
        6 => Array(0 => text_six, 1 => 1),
        7 => Array(0 => text_seven, 1 => 1),
        8 => Array(0 => text_eight, 1 => 1),
        9 => Array(0 => text_nine, 1 => 1),
        10 => Array(0 => text_ten, 1 => 1),
        11 => Array(0 => text_eleven, 1 => 1),
        12 => Array(0 => text_twelve, 1 => 1),
        13 => Array(0 => text_thirteen, 1 => 1),
        14 => Array(0 => text_fourteen, 1 => 1),
        15 => Array(0 => text_fifteen, 1 => 1),
        16 => Array(0 => text_sixteen, 1 => 1),
        17 => Array(0 => text_seventeen, 1 => 1),
        18 => Array(0 => text_eighteen, 1 => 1),
        19 => Array(0 => text_nineteen, 1 => 1)
    ),
        1 => Array(2 => Array(0 => text_twenty, 1 => 1),
            3 => Array(0 => text_thirty, 1 => 1),
            4 => Array(0 => text_forty, 1 => 1),
            5 => Array(0 => text_fifty, 1 => 1),
            6 => Array(0 => text_sixty, 1 => 1),
            7 => Array(0 => text_seventy, 1 => 1),
            8 => Array(0 => text_eighty, 1 => 1),
            9 => Array(0 => text_ninety, 1 => 1)
        ),
        2 => Array(1 => Array(0 => text_hundred, 1 => 1),
            2 => Array(0 => text_two_hundred, 1 => 1),
            3 => Array(0 => text_three_hundred, 1 => 1),
            4 => Array(0 => text_four_hundred, 1 => 1),
            5 => Array(0 => text_five_hundred, 1 => 1),
            6 => Array(0 => text_six_hundred, 1 => 1),
            7 => Array(0 => text_seven_hundred, 1 => 1),
            8 => Array(0 => text_eight_hundred, 1 => 1),
            9 => Array(0 => text_nine_hundred, 1 => 1)
        )
    );

    var $nom = Array(0 => Array(0 => text_penny, 1 => text_kopecks, 2 => text_single_kopek, 3 => text_two_penny),
        1 => Array(0 => text_ruble, 1 => text_rubles, 2 => text_one_ruble, 3 => text_two_rubles),
        2 => Array(0 => text_thousands, 1 => text_thousand, 2 => text_one_thousand, 3 => text_two_thousand),
        3 => Array(0 => text_million, 1 => text_millions, 2 => text_one_million, 3 => text_two_million),
        4 => Array(0 => text_billion, 1 => text_billions, 2 => text_one_billion, 3 => text_two_billion),
        /* :))) */
        5 => Array(0 => text_trillion, 1 => text_trillions, 2 => text_one_trillion, 3 => text_two_trillion)
    );

    var $out_rub;

    function get($summ)
    {
        if ($summ >= 1) $this->out_rub = 0;
        else $this->out_rub = 1;
        $summ_rub = doubleval(sprintf("%0.0f", $summ));
        if (($summ_rub - $summ) > 0) $summ_rub--;
        $summ_kop = doubleval(sprintf("%0.2f", $summ - $summ_rub)) * 100;
        $kop = $this->get_string($summ_kop, 0);
        $retval = "";
        for ($i = 1; $i < 6 && $summ_rub >= 1; $i++):
            $summ_tmp = $summ_rub / 1000;
            $summ_part = doubleval(sprintf("%0.3f", $summ_tmp - intval($summ_tmp))) * 1000;
            $summ_rub = doubleval(sprintf("%0.0f", $summ_tmp));
            if (($summ_rub - $summ_tmp) > 0) $summ_rub--;
            $retval = $this->get_string($summ_part, $i) . " " . $retval;
        endfor;
        if (($this->out_rub) == 0) $retval .= ' ' . text_rubles;
        return $retval . " " . $kop;
    }

    function get_string($summ, $nominal)
    {
        $retval = "";
        $nom = -1;
        $summ = round($summ);
        if (($nominal == 0 && $summ < 100) || ($nominal > 0 && $nominal < 6 && $summ < 1000)):
            $s2 = intval($summ / 100);
            if ($s2 > 0):
                $retval .= " " . $this->diw[2][$s2][0];
                $nom = $this->diw[2][$s2][1];
            endif;
            $sx = doubleval(sprintf("%0.0f", $summ - $s2 * 100));
            if (($sx - ($summ - $s2 * 100)) > 0) $sx--;
            if (($sx < 20 && $sx > 0) || ($sx == 0 && $nominal == 0)):
                $retval .= " " . $this->diw[0][$sx][0];
                $nom = $this->diw[0][$sx][1];
            else:
                $s1 = doubleval(sprintf("%0.0f", $sx / 10));
                if (($s1 - $sx / 10) > 0) $s1--;
                $s0 = doubleval($summ - $s2 * 100 - $s1 * 10);
                if ($s1 > 0):
                    $retval .= " " . $this->diw[1][$s1][0];
                    $nom = $this->diw[1][$s1][1];
                endif;
                if ($s0 > 0):
                    $retval .= " " . $this->diw[0][$s0][0];
                    $nom = $this->diw[0][$s0][1];
                endif;
            endif;
        endif;
        if ($nom >= 0):
            $retval .= " " . $this->nom[$nominal][$nom];
            if ($nominal == 1) $this->out_rub = 1;
        endif;
        return trim($retval);
    }

}

$company_query = tep_db_query("SELECT * FROM " . TABLE_COMPANIES . "
  					WHERE orders_id='" . (int)$_GET['oID'] . "'");

$company = tep_db_fetch_array($company_query);

$total_summ_query = tep_db_query("select value
	                                  from " . TABLE_ORDERS_TOTAL . "
	                                  where orders_id = '" . (int)$_GET['oID'] . "'
	                                  and class = 'ot_total'");

$total_summ = tep_db_fetch_array($total_summ_query);


$iw = new inwords;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title> &nbsp; </title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>"/>
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/>
</head>
<body>
<?php
$ids = explode(' ', $_GET['orders']);
foreach ($ids as $oID) {
    $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");

    $order = new order($oID);
    $orders_history_query = tep_db_query("select orders_status_id, date_added, customer_notified, comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$oID . "'");
    $history = tep_db_fetch_array($orders_history_query);


    ?>
    <div class="page">
        РЫБОЛОВНЫЙ МАГАЗИН <b>YOURFISH.RU</b><br>
        Москва, Щёлковское шоссе д3. стр.1 пав. 408<br>
        Телефон: 8-495-507-55-47<br><br>
        <hr>
        <b><?php echo TEXT_9; ?>:</b> <?php echo $company['name']; ?>
        <?php echo $order->customer['name']; ?>

        <?php echo nl2br(tep_db_output($history['comments'])); ?>

        <p><b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b>&nbsp;&nbsp;<?php echo $order->customer['telephone']; ?><br/>
            <b><?php echo ENTRY_EMAIL_ADDRESS; ?></b>&nbsp;&nbsp;<?php echo '<a href="mailto:' . $order->customer['email_address'] . '"><u>' . $order->customer['email_address'] . '</u></a>'; ?>
        </p>
        <p><?php echo $comments['comments']; ?></p>
        <p><?php echo '<b>' . ENTRY_PAYMENT_METHOD . '</b> ' . $order->info['payment_method']; ?><br/>
            <?php echo $payment_info; ?></p>
            
        <hr>
        <p>
            <b><font size="5"><?php echo TEXT_10; ?><?php echo '<a href="https://yourfish.ru/admin/orders.php?oID='.$oID.'&action=edit" target=_blank style="color:blue; font-size:20px">' . $oID . ' </a>' ?><?php echo TEXT_11; ?><?php echo tep_date_long($order->info['date_purchased']); ?></font></b>
        </p>
        <p>
            <b><font size="5" color="red"><?php print_r($order->statuses[$order->info['orders_status']]) ?></font></b>
        </p>

        <table border="0" width="100%" id="table1" cellspacing="0">

            <tr>
                <td width="3%" style="border-style: solid; border-width: 1px" align="center">
                    <b><?php echo TEXT_15; ?></b></td>
                <td width="67%" style="border-style: solid; border-width: 1px"
                    align="center"><?php echo TEXT_14; ?></td>
                <td width="10%" style="border-style: solid; border-width: 1px" align="center">
                    <b><?php echo TEXT_13; ?></b></td>

                <td style="border-style: solid; border-width: 1px" width="6%" align="center">
                    <b><?php echo TEXT_16; ?></b></td>
                <td width="11%" style="border-style: solid; border-width: 1px" align="center">
                    <b><?php echo TEXT_17; ?></b></td>
            </tr>
            <?php
            for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
                $num = $i + 1;
                echo '      <tr>' . "\n" .
                    '        <td width="3%" style="border-style: solid; border-width: 1px">' . $order->products[$i]['qty'] . '</td>' . "\n" .
                    '        <td width="67%" style="border-style: solid; border-width: 1px; font-size:.8em">' . $order->products[$i]['name'] . '</td>' . "\n" .
                    '        <td width="10%" style="border-style: solid; border-width: 1px; font-size:.8em">' . $order->products[$i]['model'];

                if (sizeof($order->products[$i]['attributes']) > 0) {
                    for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
                        echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
                        echo '</i></small></nobr>';
                    }
                }

                echo '        </td>' . "\n" .

                    '        <td style="border-style: solid; border-width: 1px" width="6%">' . number_format(tep_round(tep_add_tax($order->products[$i]['final_price'] * $order->info['currency_value'], $order->products[$i]['tax'], true), $currencies->currencies[$order->info['currency']]['decimal_places']), 0) . '</td>' . "\n" .
                    '        <td width="13%" style="border-style: solid; border-width: 1px">' . number_format(tep_round(tep_add_tax($order->products[$i]['final_price'] * $order->info['currency_value'] * $order->products[$i]['qty'], $order->products[$i]['tax'], true), $currencies->currencies[$order->info['currency']]['decimal_places']), 0) . '</td>' . "\n";
                '      </tr>' . "\n";
            }
            ?>


            <?php
            for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
                echo '          <tr style = "font-size:.9em">' . "\n" .
                    '            <td colspan="4" style="border-style: solid; border-width: 1px; font-size:0.9em"><p align="right"><b>' . $order->totals[$i]['title'] . '</b></p></td>' . "\n" .
                    '            <td width="13%" style="border-style: solid; border-width: 1px; font-size:1.0em">' . number_format(tep_round($order->totals[$i]['value'] * $order->info['currency_value'], $currencies->currencies[$order->info['currency']]['decimal_places']), 0) . ' руб.</td>' . "\n" .
                    '          </tr>' . "\n";
            }
            ?>
            <font size=2>
        </table>
        <u>
            <p><b><?php echo TEXT_18; ?><?php echo $iw->get($total_summ['value']); ?><?php echo TEXT_24; ?></b></p>
            <p>&nbsp;</p></font>
        </u>
        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo TEXT_19; ?> ___________________ /<?php echo TEXT_20; ?>/</b></p>
        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo TEXT_21; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></p>
    </div>
    <p style="page-break-after:always;"></p>
    <?php
}
?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>


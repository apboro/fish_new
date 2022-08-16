		﻿
		<script language="javascript" src="jquery-3.5.1.min.js"></script>
		<?php
		ini_set('display_errors', 'On');
		error_reporting('E_ALL');
		require('includes/application_top.php');
		?>
		<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html <?php echo HTML_PARAMS; ?>>
		<head>
		    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
		    <title><?php echo TITLE; ?></title>
		    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
		    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
		    <script language="javascript" src="includes/menu.js"></script>
		    <script language="javascript" src="includes/general.js"></script>
		    <script language="javascript" src="jquery-3.5.1.min.js"></script>

		    <style>
		        .search_box {
		            position: relative;
		        }

		        .search_box input[type="text"] {
		            display: block;
		            width: 100%;
		            height: 35px;
		            line-height: 35px;
		            padding: 0;
		            margin: 0;
		            border: 1px solid #fd4836;
		            outline: none;
		            overflow: hidden;
		            border-radius: 4px;
		            background-color: rgb(255, 255, 255);
		            text-indent: 15px;
		            font-size: 14px;
		            color: #222;
		        }

		        .search_box input[type="submit"] {
		            display: inline-block;
		            width: 17px;
		            height: 17px;
		            padding: 0;
		            margin: 0;
		            border: 0;
		            outline: 0;
		            overflow: hidden;
		            text-indent: -999px;
		            background: url(https://snipp.ru/demo/127/search.png) 0 0 no-repeat;
		            position: absolute;
		            top: 9px;
		            right: 16px;
		        }

		        /* Стили для плашки с результатами */
		        .search_result {
		            position: absolute;
		            top: 100%;
		            left: 0;
		            border: 1px solid #ddd;
		            background: #fff;
		            padding: 10px;
		            z-index: 9999;
		            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
		        }

		    </style>






		</head>
		<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF"
		      onload="SetFocus();">

		<!-- header //-->
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
		<!-- header_eof //-->

		<!-- body //-->
		<table border="0" width="100%" cellspacing="2" cellpadding="2">
		    <td width="<?php echo BOX_WIDTH; ?>" valign="top">


		        <!-- left_navigation //-->
		        <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
		        <!-- left_navigation_eof //-->


		    </td>
		    <td>
		        <script language="javascript" src="jquery-3.5.1.min.js"></script>
		        <?php
		        /*$tovar_query=tep_db_query("SELECT p.products_id, pd.products_name, p.products_model, p.products_quantity,
		          p.products_price, pd.products_barcode
		          FROM products as p
		          INNER JOIN products_description as pd
		          ON p.products_quantity = 11 and p.products_id = pd.products_id");

		        $tovars=tep_db_fetch_array($tovar_query);
		        */


		        ?>

		        <div class="search_box">
		            <form method="get">
		                <input autofocus type="text" name="search" id="search" placeholder="Введите артикул, название или штрихкод">
		                <input name="submit_search" type="submit">
		            </form>
		            <div id="search_box-result"></div>
		            <!--  <table border=1>
		                 <th>Название</th>
		                 <th>Артикул</th>
		                 <th>Кол-во</th>
		                 <th>Цена без скидки</th>
		                 <th>Кнопка</th>
		                 <tbody>
		 -->




		            <?php


		            if (isset($_GET['submit_search'])) {
		                $tovar_query = tep_db_query("SELECT p.products_id, 
		  pd.products_name, p.products_model,  pd.products_barcode,
		  p.products_quantity, 
		  p.products_price, 
		  pd.products_barcode
		  FROM products as p 
		  INNER JOIN products_description as pd
		  ON p.products_id = pd.products_id and concat_ws(' ', pd.products_name, p.products_model,  pd.products_barcode) LIKE '%" . trim($_GET['search']) . "%' limit 10");
		                while ($tovars = tep_db_fetch_array($tovar_query)) {
		                    $idishka = $tovars['products_id'];
		                    $kol = $tovars['products_quantity'];
		                    echo '<input type="hidden" id="' . $idishka . '" value=' . $idishka . '></input>';
		                    echo '<div style="DISPLAY: inline">';
		                    echo $tovars['products_name'] . "  | </div>";
		                    echo '<div style="DISPLAY: inline">';
		                    echo $tovars['products_model'] . "  | </div>";
		                    echo '<div style="DISPLAY: inline" id="' . $kol . '" value=' . $kol . '>' . $kol . '  | </div>';
		                    echo '<div style="DISPLAY: inline">';
		                    echo round($tovars['products_price']) . "  | </div>";
		                    echo '<button onclick="pribavit_ot_button(this)"> Добавить</button><br>';
		//echo 'товаров нашли - '. count($tovars['products_id']);
		$tovari_nashli=count($tovars['products_id']);
		                    ?>
		                    <script>
		                      window.onload = function() {
		  document.getElementById("search").focus();
}
		  function playSound(){
	var s = new Audio();
	s.src = 'knop.mp3';
	s.play();
	 console.log('здесь звучит бравурная музыка');
		};
		                        //console.log(document.getElementById('<?php// echo $idishka; ?>'))
		</script>
		                    <?php
		                }
		            }   
		//echo 'товаров нашли2 - '. $tovari_nashli;
		?>
		            <script>


		                function pribavit_ot_search(but) {

		                   let tov_id =but.value;
		                   let tov_kol = but.nextSibling.nextSibling.nextSibling.innerHTML;
		                    console.log(tov_id, tov_kol);

		                    $.ajax({
		                        type: "POST",
		                        url: 'test.php',
		                        data: {
		                            id_tovara: tov_id,
		                            kol: tov_kol
		                        },
		                        success: function (data) {
		                            //alert('Товар добавлен');
		                            //console.log(data);
		                            but.nextSibling.nextSibling.nextSibling.innerHTML = data+' |';
		                            //console.log(document.getElementById('<?php //echo $kol; ?>'));
		                  
		                        }
		    

		                    });
	
	playSound();
	

		                };

		 function pribavit_ot_button(but) {
		                   let tov_id =but.previousSibling.previousSibling.previousSibling.previousSibling.previousSibling.value;
		                    let tov_kol = but.previousSibling.previousSibling.innerHTML;
		                     console.log(tov_id, tov_kol);

		                    $.ajax({
		                        type: "POST",
		                        url: 'test.php',
		                        data: {
		                            id_tovara: tov_id,
		                            kol: tov_kol
		                        },
		                        success: function (data) {
		                            //alert('Товар добавлен');
		                            //console.log(data);
		                            but.previousElementSibling.previousElementSibling.innerHTML = data+' |';
		                            //console.log(document.getElementById('<?php //echo $kol; ?>'));

		                        }
		                    });

		                };


		           if (<?php echo $tovari_nashli; ?> ==1){
		            	let elem=document.getElementById(<?php echo $idishka; ?>)
		                console.log(elem);
		               // pribavit_ot_search(elem); //коммент чтоб если много товаров нашлось последний не прибавлялся
                              }
		            </script>

                             


		</table>
		</div>
		</tbody></table>
		                    <script>
		                      window.onload = function() {
		  document.getElementById("search").focus();
		};
		                        //console.log(document.getElementById('<?php// echo $idishka; ?>'))
		</script>
		<?php
		require(DIR_WS_INCLUDES . 'application_bottom.php');
		?>

<?php
/*
  $Id: shop_by_price.php,v 1.0 2003/5/26  $
  
  Contribution by Meltus
  http://www.highbarn-consulting.com
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- shop by price //-->
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_SHOP_BY_PRICE; ?></h5>
</div>
<div class="boxContent"><?php
require_once(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHOP_BY_PRICE);

	for ($range=0; $range<sizeof($price_ranges); $range++) {
    echo '<a href="' . tep_href_link(FILENAME_SHOP_BY_PRICE, 'range=' . $range . (isset($_GET['cPath']) ? '&amp;cPath=' . $current_category_id : null), 'NONSSL') . '">' . $price_ranges[$range] . '</a><br />' ;
   }
       
?>    
  
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<!-- shop_by_price //-->
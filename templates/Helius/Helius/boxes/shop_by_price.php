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
          <tr>
            <td>
<?php
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHOP_BY_PRICE);


  
    $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_SHOP_BY_PRICE . '</font>');
    new infoBoxHeading($info_box_contents, false, false);

    

    $info_box_contents = array();
	
	for ($range=0; $range<sizeof($price_ranges); $range++) {
    	$info_box_contents[] = array('align' => 'left',
                                 'text'  => '<a href="' . tep_href_link(FILENAME_SHOP_BY_PRICE, 'range=' . $range . (isset($_GET['cPath']) ? '&amp;cPath=' . $current_category_id : null), 'NONSSL') . '">' . $price_ranges[$range] . '</a><br>' 
                                );
	}				
    new infoBox($info_box_contents);
    
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);

?>    
  
            </td>
          </tr>
<!-- shop_by_price //-->
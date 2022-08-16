<?php
/*
  $Id: products_tabs.php, v1.0 20090909 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/


  // Set the current selected tab
  $selected_tab = 'DESC';
  if (isset ($_GET['tab']) && $_GET['tab'] != '') {
    $selected_tab = tep_clean_get__recursive ($_GET['tab']);
  }
  
?>
    <table cellpadding="0" cellspacing="0" width="100%" style="BORDER:none;background:none;">
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif','100%', '10'); ?></td>
      </tr>
        
      <tr>
        <td><table cellpadding="0" cellspacing="0" align="left" width="100%" border=0>
          <tr>
            <td>
              <div id="tabContainer">
                <div id="tabMenu">
                  <ul class="menu">
                    <li><a href="#DESC" <?php echo $selected_tab == 'DESC' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_DESCRIPTION; ?></span></a></li>
<?php
  if ($count_specificatons >= SPECIFICATIONS_MINIMUM_PRODUCTS) {
?>
                    <li><a href="#SPEC" <?php echo $selected_tab == 'SPEC' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_SPECIFICATIONS; ?></span></a></li>
<?php
  }
  
  if ($product_info['products_tab_1'] > '') {
?>
                    <li><a href="#TAB_1" <?php echo $selected_tab == 'TAB_1' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_1; ?></span></a></li>
<?php
  }

  if ($product_info['products_tab_2'] > '') {
?>
                    <li><a href="#TAB_2" <?php echo $selected_tab == 'TAB_2' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_2; ?></span></a></li>
<?php
  }

  if ($product_info['products_tab_3'] > '') {
?>
		
                    <li><a href="#TAB_3" <?php echo $selected_tab == 'TAB_3' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_3; ?></span></a></li>
<?php
  }

  if ($product_info['products_tab_4'] > '') {
?>
		
                    <li><a href="#TAB_4" <?php echo $selected_tab == 'TAB_4' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_4; ?></span></a></li>
<?php
  }

  if ($product_info['products_tab_5'] > '') {
?>
		
                    <li><a href="#TAB_5" <?php echo $selected_tab == 'TAB_5' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_5; ?></span></a></li>
<?php
  }

  if ($product_info['products_tab_6'] > '') {
?>
                    <li><a href="#TAB_6" <?php echo $selected_tab == 'TAB_6' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_6; ?></span></a></li>
<?php
  }
?>
<?php
  if (SPECIFICATIONS_REVIEWS_TAB == 'True') {
?>
                    <li><a href="#REVIEW" <?php echo $selected_tab == 'REVIEW' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_REVIEWS; ?></span></a></li>
<?php
  }
?>
<?php
  if (SPECIFICATIONS_QUESTION_TAB == 'True') {
?>
                    <li><a href="#ASK" <?php echo $selected_tab == 'ASK' ? 'class="active"' : ''; ?>><span><?php echo TEXT_TAB_ASK_A_QUESTION; ?></span></a></li>
<?php
  }
?>
                  </ul>
                </div> 
  
                <div id="tabContent">
                  <div id="DESC" class="content<?php echo $selected_tab == 'DESC' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo TEXT_TAB_DESCRIPTION_HEAD; ?></div>
                    <br>
<?php
  echo stripslashes ($product_info['products_description']);
?>
                  </div>
<?php

  if (strlen ($specification_text) > 36) {
?>
                  <div id="SPEC" class="content<?php echo $selected_tab == 'SPEC' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo TEXT_TAB_SPECIFICATIONS_HEAD; ?></div>
                    <br>
<?php
    echo stripslashes ($specification_text);
?>
                  </div>
<?php
  }

  if ($product_info['products_tab_1'] > '') {
?>          
                  <div id="TAB_1" class="content<?php echo $selected_tab == 'TAB_1' ? ' active' : ''; ?>">
                    <div class="inside_heading"> <?php echo TEXT_TAB_1; ?></div>
                    <br>
<?php
    echo stripslashes($product_info['products_tab_1']);
?>
                  </div>
<?php
  }

  if ($product_info['products_tab_2'] > '') {
?>          
                  <div id="TAB_2" class="content<?php echo $selected_tab == 'TAB_2' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo TEXT_TAB_2; ?></div>
                    <br>
<?php
    echo stripslashes ($product_info['products_tab_2']);
?>
                  </div>
<?php
  }

  if ($product_info['products_tab_3'] > '') {
?>          
                  <div id="TAB_3" class="content<?php echo $selected_tab == 'TAB_3' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo TEXT_TAB_3; ?></div>
                    <br>
<?php
    echo stripslashes ($product_info['products_tab_3']);
?>
                  </div>
<?php
  }

  if ($product_info['products_tab_4'] > '') {
?>
                  <div id="TAB_4" class="content<?php echo $selected_tab == 'TAB_4' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo TEXT_TAB_4; ?></div>
                    <br>
<?php
    echo stripslashes ($product_info['products_tab_4']);
?>
                  </div>
<?php
  }

  if ($product_info['products_tab_5'] > '') {
?>          
                  <div id="TAB_5" class="content<?php echo $selected_tab == 'TAB_5' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo TEXT_TAB_5; ?></div>
                    <br>
<?php
    echo stripslashes ($product_info['products_tab_5']);
?>
                  </div>
<?php
  }

  if ($product_info['products_tab_6'] > '') {
?>          
                  <div id="TAB_6" class="content<?php echo $selected_tab == 'TAB_6' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo TEXT_TAB_6; ?></div>
                    <br>
<?php
    echo stripslashes ($product_info['products_tab_6']);
?>
                  </div>
<?php
  }
?>
<?php
    if (SPECIFICATIONS_REVIEWS_TAB == 'True') {
      include (DIR_WS_MODULES . FILENAME_PRODUCT_REVIEWS);
    }
?>
<?php
    if (SPECIFICATIONS_QUESTION_TAB == 'True') {
      include (DIR_WS_MODULES . FILENAME_ASK_A_QUESTION);
    }
?>


                  </div>  
                </div> 
              </td>
            </tr>
          </table></td>
        </tr>
      </table>
        

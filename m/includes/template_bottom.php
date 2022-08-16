<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/
?>
</div>
<?php
  if ($oscTemplate->hasBlocks('boxes_column_left')) {
?>
	<div id="mj-left" class="mj-grid16 mj-lspace"> 
  		<?php echo $oscTemplate->getBlocks('boxes_column_left'); ?>
	</div> 
<?php
  }
  if ($oscTemplate->hasBlocks('boxes_column_right') &&  basename($PHP_SELF) != FILENAME_PRODUCT_INFO) {
?>
	<div id="mj-right" class="mj-grid16 mj-lspace mj-rspace"> 
  		<?php echo $oscTemplate->getBlocks('boxes_column_right'); ?>
	</div> 

<?php
  }
?>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<?php echo $oscTemplate->getBlocks('footer_scripts'); ?>
<div style="display:none">
<?php require(DIR_WS_INCLUDES.'counters_footer.php')?>
</div>

</body>
</html>
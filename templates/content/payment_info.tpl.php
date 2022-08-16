<?php 
$confirmation=GetPaymentString( $order->info['payment_method']);
if (!is_array($confirmation)){return;}
if (strlen(trim($confirmation['confirmation']['title']))==0){return;}
?>
<tr><td colspan="2">
<table>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" colspan="4"><?php echo $confirmation['confirmation']['title']; ?></td>
              </tr>
<?php
      for ($i=0, $n=sizeof($confirmation['confirmation']['fields']); $i<$n; $i++) {
?>
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main"><?php echo $confirmation['confirmatin']['fields'][$i]['title']; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main"><?php echo $confirmation['confirmatin']['fields'][$i]['field']; ?></td>
              </tr>
<?php
      }
?>
            </table></td>
          </tr>
        </table></td>
      </tr>
</table>
</td></tr>
<?php
function GetPaymentString($str){
    global $language;
try{
	    // Get list of all payment modules available
            $enabled_payment = array();
            $module_directory = DIR_FS_CATALOG.DIR_WS_MODULES . 'payment/';
            $file_extension = '.php';
             if ($dir = @dir($module_directory)) {
              while ($file = $dir->read()) {
               if (!is_dir( $module_directory . $file)) {
                if (substr($file, strrpos($file, '.')) == $file_extension) {
                   $directory_array[] = $file;
                 }
               }
             }
            sort($directory_array);
            $dir->close();
           }
          // For each available payment module, check if enabled
          for ($i=0, $n=sizeof($directory_array); $i<$n; $i++) {
          $file = $directory_array[$i];
          include(DIR_WS_LANGUAGES . $language . '/modules/payment/' . $file);
          include($module_directory . $file);
          $class = substr($file, 0, strrpos($file, '.'));
          if (class_exists($class)) {
             $module = new $class;
             if ($module->check() > 0) {
              // If module enabled create array of titles
	$data=array('confirmation'=>$module->confirmation(),
		    'selection'=>$module->selection());
      if (preg_match('|^'.preg_quote(trim($str)).'|',$module->title)) {
	//return $module->confirmation['title'];
//	$data=$module->selection();
	return $data;
          }
              }
            }
          }
}catch(Exception $e){}
return '';
}
?>
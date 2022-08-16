<?php
  if ($messageStack->size('header') > 0) {
    echo '<div class="grid_24">' . $messageStack->output('header') . '</div>';
  }
?>
<div id="mj-topbar">
    	<div class="mj-subcontainer">
            <div style="margin:0px;margin-top:-5px;margin-left:30px;" class="nowrap mj-grid16 mj-lspace"><?php echo TEXT_CALL_US; ?>
			<?php echo OSMARTVAL_CALL_US; ?></div>             	
            <div id="headerShortcuts" class="mj-rspace">
            	<ul class="menu"> 
					<?php
/*    		     echo '<li><span class = "menu_txt">' .tep_draw_button(HEADER_TITLE_HOME, null, tep_href_link(FILENAME_DEFAULT, '', 'SSL')) . '</span></li>';
		      if (!tep_session_is_registered('customer_id')) {
                      echo '<li><i class="fa fa-angle-right fa-2x menu_bar"><span class = "menu_txt">' . tep_draw_button(HEADER_TITLE_LOGIN, null, tep_href_link(FILENAME_LOGIN, '', 'SSL')) . '</span></i></li>';
                      }

                      echo '<li><i class="fa fa-angle-right fa-2x menu_bar"><span class = "menu_txt">' . tep_draw_button(HEADER_TITLE_CHECKOUT, 'triangle-1-e', tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . '</span></i></li>' ;
		      if (is_object($page_cache)){$cart_content_counter='<%CART_COUNTER%>';}
		        else{$cart_content_counter= $cart->count_contents();}
                      echo '<li><i class="fa fa-angle-right fa-2x menu_bar"><span class = "menu_txt">' . tep_draw_button(HEADER_TITLE_CART_CONTENTS . ($cart->count_contents() > 0 ? ' <span id="scartbox_counter">(' .$cart_content_counter . ')</span>' : '<span id="scartbox_counter"></span>'
					  ), 'cart', tep_href_link(FILENAME_SHOPPING_CART)) . '</span></i></li>';
                       if (tep_session_is_registered('customer_id')) {
                      echo '<li><i class="fa fa-angle-right fa-2x menu_bar"><span class = "menu_txt">' . tep_draw_button(HEADER_TITLE_LOGOFF, null, tep_href_link(FILENAME_LOGOFF, '', 'SSL')) . '</span></i></li>';
		      echo '<li><i class="fa fa-angle-right fa-2x menu_bar"><span class = "menu_txt">' . tep_draw_button(HEADER_TITLE_MY_ACCOUNT, 'person', tep_href_link(FILENAME_ACCOUNT, '', 'SSL')) . '</span></i></li>';                      }

*/    		     echo '<li>' .
		     '<a title="'.HEADER_TITLE_HOME.'" href="'.tep_href_link(FILENAME_DEFAULT,'','SSL').'"><i class="fa fa-2x fa-home"></i></a></li>';
		      if (!tep_session_is_registered('customer_id')) {
                      echo '<li>
                        <i class="fa  fa-2x menu_bar"></i>
                        <a title="'.HEADER_TITLE_LOGIN.'" href="'.tep_href_link(FILENAME_LOGIN, '', 'SSL').'">
                        <i class="fa fa-sign-in fa-2x menu_bar"></i></a></li>';
                      }

                      echo '<li><i class="fa  fa-2x menu_bar"></i>
                      <a title="'.HEADER_TITLE_CHECKOUT.'" href="'.tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL').'">
                      <i class="fa fa-2x fa-check-circle menu_bar"></i></a></li>' ;
                      
		      if (is_object($page_cache)){$cart_content_counter='<%CART_COUNTER%>';}
		        else{$cart_content_counter= $cart->count_contents();}
                      echo '<li><i class="fa  fa-2x menu_bar"></i>'.
                      '<a title="'.HEADER_TITLE_CART_CONTENTS.'" href="'.tep_href_link(FILENAME_SHOPPING_CART,'','SSL').'">'.
                      '<i class="fa fa-2x fa-shopping-cart menu_bar">'.
                      ($cart->count_contents() > 0 ? ' <span id="scartbox_counter">(' .$cart_content_counter . ')</span>' : '<span id="scartbox_counter"></span>').
                      '</i>'.
                      '</a></li>';
                      if (tep_session_is_registered('customer_id')) {
                      echo '<li>
                      <i class="fa  fa-2x menu_bar"></i>
                      <a title="'.HEADER_TITLE_LOGOFF.'" href="'.tep_href_link(FILENAME_LOGOFF, '', 'SSL').'">
                      <i class="fa fa-2x menu_bar fa-sign-out"></i></a></li>';
	/*	      echo '<li><i class="fa  fa-2x menu_bar"></i>
		      <a title="'.HEADER_TITLE_MY_ACCOUNT.'" href="'.tep_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.
		      '<i class="fa fa-2x menu_bar fa-user"></i></a></li>';*/
		         }


                    ?>
                 </ul>
  			</div>
        </div>

</div>
<div id="auto-top" style="height:100px"></div>
<script type="text/javascript">
    var jqh=jQuery.noConflict();
    jqh("#auto-top").height(jqh("#mj-topbar").height()+20);
    jqh(window).resize(function(){
	jqh("#auto-top").height(jqh("#mj-topbar").height()+20);
	});
</script>
	<div class="breadcrumb_addon">

	<div style="width:100%;">
                    <div class="search">
                    <table style="border:none;width:100%;"><tr><td>
                    <div class="new_cat"><button class="new_cat_btn"><span>Каталог <i class="fa fa-angle-right"></i></span></button></div>
                    </td><td>
                    
					
 					<?php echo tep_draw_form('search',tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false),'get') ?>
                    <table style="border:none;width:100%;"><tr><td>
                    		 <input type="text" name="keywords" class="go"  value="<?php echo INPUT_SEARCH ?>" 
                    		onblur="if(this.value=='') this.value='<?php echo INPUT_SEARCH ?>'" onfocus="if(this.value =='<?php echo INPUT_SEARCH ?>' ) this.value=''" />
                     		</td><td style="text-align:left">
                     		<button id="search-button" type="submit"><span><?php echo TEXT_SEARCH; ?></span></button>
                     		 </div> 
							
	<!-- поиск zib

	<style type="text/css">
   .ya-site-form { 
    width: 80%;
	
	   }
	.ya-site-form_inited_no {
		 width: 80%;
	     
	}



  </style> 
                      		  <div class="ya-site-form ya-site-form_inited_no" data-bem="{&quot;action&quot;:&quot;http://yourfish.ru/results.php&quot;,&quot;arrow&quot;:false,&quot;bg&quot;:&quot;transparent&quot;,&quot;fontsize&quot;:17,&quot;fg&quot;:&quot;#333333&quot;,&quot;language&quot;:&quot;ru&quot;,&quot;logo&quot;:&quot;rb&quot;,&quot;publicname&quot;:&quot;поиск yourfish.ru&quot;,&quot;suggest&quot;:true,&quot;target&quot;:&quot;_self&quot;,&quot;tld&quot;:&quot;ru&quot;,&quot;type&quot;:2,&quot;usebigdictionary&quot;:true,&quot;searchid&quot;:2464514,&quot;input_fg&quot;:&quot;#000000&quot;,&quot;input_bg&quot;:&quot;#ffffff&quot;,&quot;input_fontStyle&quot;:&quot;normal&quot;,&quot;input_fontWeight&quot;:&quot;normal&quot;,&quot;input_placeholder&quot;:&quot;Поиск по сайту&quot;,&quot;input_placeholderColor&quot;:&quot;#000000&quot;,&quot;input_borderColor&quot;:&quot;#7f9db9&quot;}">
  <form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8"><input type="hidden" name="searchid" value="2464514"/>
  <input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="search" name="text" value=""/><input  type="image" src="/images/search/button_quick_find.gif" /><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style>
  <script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>


															
                                                     
													
													 
													 
-->															 

					
							
                     		<div class="social_icons_search">
     		                   <a href="<?php echo SOCIAL_VK_A; ?>"><i class="fa fa-vk fa-2x"></i></a>
                                  <a  href="<?php echo SOCIAL_YOUTUBE_A; ?>"><i class="fa fa-youtube fa-2x"></i></a>
                                     <a href="<?php echo SOCIAL_TWITTER_A; ?>"><i class="fa fa-tumblr-square fa-2x"></i></a>
                                 </div>
                     		</form>
                     		</td></tr></table>
		    </form>
		    </td></tr></table>
                    </div> 

            </div>
<div id="new_catalog">
	<div class="new_cat_menu"><?php echo GetCategoryMenu(); ?></div>
</div>


	</div>
	<div id="mj-righttop"> 
    	<div class="mj-subcontainer">
    		<div id="mj-menubar">
    			<div class="jsn-mainnav navbar">
					<div class="jsn-mainnav-inner navbar-inner">
						<div class="container clearfix">
                        	<div class="mainnav-toggle clearfix">
                    			<button  id="btn" type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse" > <span><?php echo TEXT_MAIN_MENU; ?></span></button>
                			</div>
   							<div id="jsn-pos-mainnav" class="nav-collapse collapse clearfix">
    							<ul class="nav">
                                    <li  <?php echo $item_menu_01;?>  onclick="document.location='<?php echo tep_href_link('index.php')?>'"><a>Магазин</a>
                                    </li>
                                     <li><a href="/discount.php">Скидки</a></li>
                                    <li><a href="/information.php/pages_id/6">Доставка</a></li>
                                    <li><a href="http://touryour.ru/">Туристическое снаряжение</a></li>
                                    <li><a href="/map.php">Схема проезда</a></li>
    							</ul>
    						</div> 
    					</div>
    				</div>
				</div>
                <script type="text/javascript">

				
				var addcls = jQuery.noConflict();
				addcls(".navbar-inner button#btn").click(function(){
					 if (addcls(".navbar-inner #jsn-pos-mainnav").hasClass('intro')) {
  						addcls(".navbar-inner #jsn-pos-mainnav").removeClass("intro");
					 }
					 else {
						 addcls(".navbar-inner #jsn-pos-mainnav").addClass("intro");
					 }
					
				}); 
					
				</script>
    		</div> 
    	</div> 
    </div> 
<?php
/*$breadcrumb->_trail[0]['title']='<div class="new_cat">Каталог</div><div class="new_cat_menu">'.GetCategoryMenu().'</div>';
$breadcrumb->_trail[0]['link']="javascript:void()";*/
if((basename($PHP_SELF) == FILENAME_DEFAULT && $cPath == '') && !isset($_GET['manufacturers_id']) ) { 
    }else{$al1 = $breadcrumb->trailMobi(' ');
?>

<div id="mj-slidetitle"> 
	<div class="mj-subcontainer"> 
        <div class="mj-grid96  breadcrumb"  style="margin:0px;">
            <div class="breadcrumbs  mj-grid96 breadcrumb"  style="margin:0px;"> 
                    <div id="navBreadCrumb"><ul><?php echo $al1; ?></ul></div> 
            </div>
        </div> 
    </div> 
</div>
<?php   
}
    if((basename($PHP_SELF) == FILENAME_DEFAULT && $cPath == '') && !isset($_GET['manufacturers_id']) ) { 
/*$osmart_query = tep_db_query("select * from " . osmart);
while($osmart_slider = tep_db_fetch_array($osmart_query)){
		$slider = $osmart_slider['osmart_slider'];
		$slider='disable';
} */
$slider='disable';

}else{  } 
  if (isset($HTTP_GET_VARS['error_message']) && tep_not_null($HTTP_GET_VARS['error_message'])) {
?>
<table class="table-padding-2">
  <tr class="headerError">
    <td class="headerError"><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['error_message']))); ?></td>
  </tr>
</table>
<?php
  }
  if (isset($HTTP_GET_VARS['info_message']) && tep_not_null($HTTP_GET_VARS['info_message'])) {
?>
<table class="table-padding-2">
  <tr class="headerInfo">
    <td class="headerInfo"><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['info_message']))); ?></td>
  </tr>
</table>
<?php
  }
?>

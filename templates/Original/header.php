<?php
/*
  $Id: header.php,v 1.42 2003/06/10 18:20:38 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
define('DIR_WS_TEMPLATE_IMAGES', 'templates/Original/images/');

// WebMakers.com Added: Down for Maintenance
// Hide header if not to show
if (DOWN_FOR_MAINTENANCE_HEADER_OFF =='false') {

if (SITE_WIDTH!='100%') {
?>
<table width="<?php
if (isset($_SESSION['client'])&&isset($_SESSION['client']['rW'])){echo $_SESSION['client']['rW'].'px';}
else{echo '100%';}
?>" cellpadding="10" cellspacing="0" border="0" BGCOLOR="#ffffff">
    <tr><td>
            <table BORDERCOLORLIGHT="c3c3c3" CELLSPACING="2" CELLPADDING="4" BORDER="0" width="<?php echo SITE_WIDTH;?>" align="center" BGCOLOR="FFFFFF" align="center">
                <tr><td BORDERCOLOR="c3c3c3">
                        <table border="0" width="100%"><tr><td>
                                    <?php
                                    }
                                    ?>
                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="/ext/js/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                                    <?php if (SHOW_HEADING_TITLE_ORIGINAL == 'yes'){ ?>
                                        <table class="header_table">
                                            <tr>
                                                <td width="10%"></td>
                                                <td>
                                                    <img src="images/yourFish.jpg" alt="Рыболовный интеренет-магазин" height="170" width="950"/>
                                                </td>
                                                <td width="10%"></td></tr>
                                        </table>
                                        <!--<div class="wr-info">
                                            <a href="/aktsiya-n-91" target="_blank">
                                            При покупке 5-ти любых приманок или лесок - любая удочка, спиннинг или катушка со скидкой 15%!
                                            </a>
                                        </div> --> 
                                        <table class="table-padding-1">
                                            <tr class="headerNavigation" style="background: black url('/images/glossyback.gif') repeat-x scroll left bottom;text-align:center;">
                                                <td  class="headerNavigation" style="background: black url('/images/glossyback.gif') repeat-x scroll left bottom;text-align:center;">
                                                    <div class="header_menu">
                                                        <a href="/">Магазин</a>
                                                        <!-- <a href="/specials.php">Скидки</a> -->
														<a href="/products_new.php">Новинки</a>
                                                        <!-- <a href="/pops.php">Популярное</a>-->
                                                        <a href="/information.php/pages_id/6">Доставка</a>
                                                       <!-- <a href="http://touryour.ru">Туристическое снаряжение</a> -->
                                                        <a href="/map.php">Схема проезда</a>
                                                        <?php
                                                        global $regions;
                                                        echo $regions->displayChooseRegion();
                                                        ?>
														
                                                    
													
															</div>
                                                    <?php /*
/*------------replace code of search form at main page-----*/
                                                    ?>
                                                </td><td style="background: black url('/images/glossyback.gif') repeat-x scroll left bottom;text-align:center;">
                                                    <div class="div_kw">
                                                        <form action="<?=tep_href_link('advanced_search_result.php');?>" method="get">
                                                            	<!-- <input type="hidden" name="search_in_description" value="1"> -->
                                                            <input type="hidden" value="0" id="search_page1">
                                                             <input id="kw1" size="35" maxlength="100" autocomplete="off" value="<?php
                                                             echo $_GET['text']; 
															 echo $_GET['keywords']; ?>" type="text" name="keywords" placeholder="Поиск по сайту">
														   <div id="keywords1" class="keywords"></div>
                                                            <input  type="image" src="/images/search/button_quick_find.gif" />
															<div class="social_icons_search">
                                                                <a target="_blank" href="<?php echo SOCIAL_VK_A; ?>"><i class="fa fa-vk fa-1x"></i></a>
                                                                <a target="_blank"   href="<?php echo SOCIAL_YOUTUBE_A; ?>"><i class="fa fa-youtube fa-1x"></i></a>
                                                                <a  target="_blank" href="<?php echo SOCIAL_TWITTER_A; ?>"><i class="fa fa-tumblr-square fa-1x"></i></a>
                                                            </div>
															   </form> 
                                                    </div>
<style type="text/css">
   .ya-site-form { 
    width: 350px;
	
	   }
	.ya-site-form_inited_no {
		 width: 350px;
	     
	}
	.social_icons_search {
		display: none;
	}


  </style> 
  <!--<div class="ya-site-form ya-site-form_inited_no" data-bem="{&quot;action&quot;:&quot;http://yourfish.ru/results.php&quot;,&quot;arrow&quot;:false,&quot;bg&quot;:&quot;transparent&quot;,&quot;fontsize&quot;:12,&quot;fg&quot;:&quot;#333333&quot;,&quot;language&quot;:&quot;ru&quot;,&quot;logo&quot;:&quot;rb&quot;,&quot;publicname&quot;:&quot;поиск yourfish.ru&quot;,&quot;suggest&quot;:true,&quot;target&quot;:&quot;_self&quot;,&quot;tld&quot;:&quot;ru&quot;,&quot;type&quot;:2,&quot;usebigdictionary&quot;:true,&quot;searchid&quot;:2464514,&quot;input_fg&quot;:&quot;#000000&quot;,&quot;input_bg&quot;:&quot;#ffffff&quot;,&quot;input_fontStyle&quot;:&quot;normal&quot;,&quot;input_fontWeight&quot;:&quot;normal&quot;,&quot;input_placeholder&quot;:&quot;Поиск по сайту&quot;,&quot;input_placeholderColor&quot;:&quot;#000000&quot;,&quot;input_borderColor&quot;:&quot;#7f9db9&quot;}">
  <form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8"><input type="hidden" name="searchid" value="2464514"/>
  <input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="search" name="text" value=""/><input  type="image" src="/images/search/button_quick_find.gif" /><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style>
  <script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>


															
                                                     </form> -->
													
													 
													       

                                                    <?php
                                                    /*-- new search engine -*/
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr class="headerNavigation">
                                                <td class="headerNavigation"><?php echo $breadcrumb->trail(' &raquo; '); ?></td>
                                                <td align="right" class="headerNavigation"><?php if (tep_session_is_registered('customer_id')) { ?><a href="<?php echo tep_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>" class="headerNavigation"><?php echo HEADER_TITLE_LOGOFF; ?></a> &nbsp;|&nbsp; <?php }
                                                    /*
                                                    ?>
                                                    <!--<a href="<?php echo tep_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>" class="headerNavigation"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a> &nbsp;|&nbsp;-->
                                                    <?php */?>
                                                    <a href="<?php echo tep_href_link(FILENAME_SHOPPING_CART); ?>" class="headerNavigation"><?php echo HEADER_TITLE_CART_CONTENTS; ?></a> &nbsp;|&nbsp; <a href="<?php echo tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>" class="headerNavigation"><?php echo HEADER_TITLE_CHECKOUT; ?></a> &nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                        <?php /* ?>
  </tr>
</table>
<?php */ ?>
                                    <?php } ?>

                                    <?php
                                    }
                                    ?>
                                    <!-- header_eof //-->



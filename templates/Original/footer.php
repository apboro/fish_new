<?php
/*
  $Id: footer.php,v 1.26 2003/02/10 22:30:54 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/



// WebMakers.com Added: Down for Maintenance
// Hide footer.php if not to show
if (isset($javascript_footer)) {
    if (is_array($javascript_footer)) {
        foreach ($javascript_footer as $script) {
            if (file_exists(DIR_WS_JAVASCRIPT . basename($script))) {
                require(DIR_WS_JAVASCRIPT . basename($script));
            }
        }
    } else {
        if (file_exists(DIR_WS_JAVASCRIPT . basename($javascript_footer))) {
            require(DIR_WS_JAVASCRIPT . basename($javascript_footer));
        }
    }
}


if ($session_started && !isset($_SESSION['client'])){
?>
<script type="text/javascript">
$.ajax({
    url:'/cdata.php',
    method:'GET',
    data:{rW : $(window).width(),rH:$(window).height()}
    });
</script>
<?php
}

if (DOWN_FOR_MAINTENANCE_FOOTER_OFF =='false') {
  require(DIR_WS_INCLUDES . 'counter.php');
?>
<table class="table-padding-1">
  <tr class="footer">
    <td class="footer"></td>
    <td align="right" class="footer">&nbsp;&nbsp;<a href="https://yourfish.ru/sitemapindex.xml">
	<?php// echo echoHTTP().$_SERVER['HTTP_HOST'];?> <!--	/sitemaphtml/SiteMap1.html">-->
	Карта сайта</a></td>
  </tr>
</table>
<table class="table-padding-0">
  <tr>
    <td align="center" class="main">
<center><p class="copyright">© <a href="<?php echo echoHTTP().$_SERVER['HTTP_HOST'];?>/">Рыболовный интернет магазин</a> YourFish.ru, 2008-<?php echo date ( 'Y' ) ; ?>г.</p>
    <?php
    global $regions;
    ?>
    Москва, 4й Лихачевский переулок дом 2 строение 2 тел: 8 (800) 222 41 49
<br>
    Обращаем ваше внимание на то, что данный интернет-сайт носит исключительно информационный
    характер и ни при каких условиях не является публичной офертой, определяемой положениями
    Статьи 437 (2) Гражданского кодекса Российской Федерации.
    Для получения подробной информации о наличии и стоимости указанных товаров и (или) услуг,
    пожалуйста, обращайтесь к менеджеру сайта с помощью специальной формы связи или по телефону
    8-800-222-41-49
    <br>
В рыболовном интернет магазине доставка почтой рыболовных снастей осуществляется также в следующие регионы России: Москва, Санкт-Петербург, Новосибирск, Екатеринбург, Нижний Новгород, Казань, Самара, Омск, Челябинск, Ростов-на-Дону, Уфа, Волгоград, Красноярск, Пермь, Воронеж, Саратов, Краснодар, Тольятти, Барнаул, Ульяновск, Тюмень, Ижевск, Иркутск, Владивосток, Хабаровск, Улан-Удэ, Подольск, Салехард, Тверь, Сочи, Псков, Петрозаводск, Мурманск.<br>

<style type="text/css">
   .ya-site-form { 
    width: 200px;
	
	   }
	.ya-site-form_inited_no {
		 width: 200px;
	
	}
  </style> 
 
<!-- Поиск старый
 <form action="<?=tep_href_link('advanced_search_result.php');?>" method="get">
                                                            	<input type="hidden" name="search_in_description" value="1"> 
                                                            <input type="hidden" value="0" id="search_page1">
                                                             <input id="kw1" size="20" maxlength="100" autocomplete="off" value="<?php //echo $_GET['keywords']; ?>" type="text" name="keywords" placeholder="Поиск по сайту">
														   <div id="keywords1" class="keywords"></div>
                                                            <input  type="image" src="/images/search/button_quick_find.gif" />
															
															   </form> <br>

-->

<!--
  <div class="ya-site-form ya-site-form_inited_no" data-bem="{&quot;action&quot;:&quot;http://yourfish.ru/results.php&quot;,&quot;arrow&quot;:false,&quot;bg&quot;:&quot;transparent&quot;,&quot;fontsize&quot;:12,&quot;fg&quot;:&quot;#333333&quot;,&quot;language&quot;:&quot;ru&quot;,&quot;logo&quot;:&quot;rb&quot;,&quot;publicname&quot;:&quot;поиск yourfish.ru&quot;,&quot;suggest&quot;:true,&quot;target&quot;:&quot;_self&quot;,&quot;tld&quot;:&quot;ru&quot;,&quot;type&quot;:2,&quot;usebigdictionary&quot;:true,&quot;searchid&quot;:2464514,&quot;input_fg&quot;:&quot;#000000&quot;,&quot;input_bg&quot;:&quot;#ffffff&quot;,&quot;input_fontStyle&quot;:&quot;normal&quot;,&quot;input_fontWeight&quot;:&quot;normal&quot;,&quot;input_placeholder&quot;:&quot;Поиск по сайту&quot;,&quot;input_placeholderColor&quot;:&quot;#000000&quot;,&quot;input_borderColor&quot;:&quot;#7f9db9&quot;}">
  <form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8"><input type="hidden" name="searchid" value="2464514"/>
  <input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="search" name="text" value=""/><input  type="image" src="/images/search/button_quick_find.gif" /><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style>
  <script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>


															
                                                     </form> -->



<!--Counters-->

<center>
<span class="smallText">
<?php
require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/counters.txt');
?>
</span>
</center>

<!--/Counters-->

<center>
<span class="smallText">

<?php if (DISPLAY_PAGE_PARSE_TIME == 'true') { ?>
<?php echo TOTAL_QUERIES . $query_counts; ?>
<br>
<?php echo TOTAL_TIME . $query_total_time; ?>
<?php } ?>
</span>
</center>

<?php echo FOOTER_TEXT_BODY; ?>



<!-- footer_eof //-->


    </td>
  </tr>
</table>
<?php
}
  if ($banner = tep_banner_exists('dynamic', '468x50')) {
?>
<br>
<table class="table-padding-0">
  <tr>
    <td align="center"><?php echo tep_display_banner('static', $banner); ?></td>
  </tr>
</table>
<?php
  }
?>
<br>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter2570989 = new Ya.Metrika({id:2570989,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//<?php echo $_SERVER['SERVER_NAME'];?>/ext/js/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");

</script>

    <script src="//www.gstatic.com/firebasejs/5.2.0/firebase.js"></script>
    <script src="/firebase_subscribe.js"></script>
    <script type='text/javascript'> (function(d, w, m) { window.supportAPIMethod = m; var s = d.createElement('script'); s.type ='text/javascript'; s.id = 'supportScript'; s.charset = 'utf-8'; s.async = true; var id = '7080916fb9ef2018eab85d8dacb2d3ec'; s.src = '//me-talk.ru/support/support.js?h='+id; var sc = d.getElementsByTagName('script')[0]; w[m] = w[m] || function() { (w[m].q = w[m].q || []).push(arguments); }; if (sc) sc.parentNode.insertBefore(s, sc); else d.documentElement.firstChild.appendChild(s); })(document, window, 'MeTalk'); async</script>
<noscript><div><img src="//mc.yandex.ru/watch/2570989" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


    <link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript" src="jscript/jquery/plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<?php if (PRODUCTS_DISPLAY===true){?>
<script type="text/javascript">
jQuery(".qview a.qover").each(function(){
    jQuery(this).find('div').attr('href',jQuery(this).attr('href')+'?ajax=1');
    });
jQuery("td.qview a.qover div,tr.qview a.qover div").fancybox({
        "imageScale"        :true,
        "modal"            :false,
        "hideOnContentClick"    :false,
        "zoomOpacity"        : true,
        "showCloseButton"    : true,
        "overlayShow"        : false,
        "zoomSpeedIn"        : 500,
        "zoomSpeedOut"        : 500,
	"margin"	: 150,
	"enableEscapeButton" : true,
	"hideOnOverlayClick" : true,
	"overlayShow"	: true,
//	"modal"		: true,
	"width"		: "80%",
	"height"	: "80%" ,
	"autoScale"	: true,
//	"autoDimensions" : false,
    });
</script>
<?php }?>
<!-- footer_eof //-->
<?php
if ($content=='product_info'){
if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
            $cell=round($new_price,0);
            } else {
            $cell= round(tep_xppp_getproductprice($product_info['products_id']),0);
          }
?>
<script type="text/javascript">
var google_tag_params = {
ecomm_prodid: "<?php echo $product_info['products_id'];?>",
ecomm_pagetype: "product",
dynx_itemid: "<?php echo $product_info['products_id'];?>"
};
</script>

<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({
type: 'itemView',
productid: '<?php echo $product_info['products_id'];?>',
pagetype: 'product',
list: '1',
totalvalue: '<?php echo $cell;?>'
});
</script>

<script type="text/javascript">
 fbq('track', 'ViewContent', {
   content_ids: ['<?php echo $product_info['products_id'];?>'],
   content_type: 'product',
   value: <?php echo $cell;?>,
   currency: 'RUB'
     });
</script>

<?php }

global $regions;
echo $regions->displayScripts();
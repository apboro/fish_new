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
        "margin"        : 150,
        "enableEscapeButton" : true,
        "hideOnOverlayClick" : true,
        "overlayShow"   : true,
//      "modal"         : true,
        "width"         : "80%",
        "height"        : "80%" ,
        "autoScale"     : true,
//      "autoDimensions" : false,
    });
	
</script>
<?php }?>


<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t44.15;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='31' height='31'><\/a>")
//--></script><!--/LiveInternet-->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter10527676 = new Ya.Metrika({id:10527676,
                    clickmap:true,
                    accurateTrackBounce:true});
        }
        catch(e) { }
    });
})(window, "yandex_metrika_callbacks");
</script>
    <!-- Begin Me-Talk {literal} -->
    <script type='text/javascript'>
        (function(d, w, m) {
            window.supportAPIMethod = m;
            var s = d.createElement('script');
            s.type ='text/javascript'; s.id = 'supportScript'; s.charset = 'utf-8';
            s.async = true;
            var id = '7080916fb9ef2018eab85d8dacb2d3ec';
            s.src = '//me-talk.ru/support/support.js?h='+id;
            var sc = d.getElementsByTagName('script')[0];
            w[m] = w[m] || function() { (w[m].q = w[m].q || []).push(arguments); };
            if (sc) sc.parentNode.insertBefore(s, sc);
            else d.documentElement.firstChild.appendChild(s);
        })(document, window, 'MeTalk');
		async
    </script>
    <!-- {/literal} End Me-Talk -->
<script src="/ext/js/watch.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/10527676" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
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
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//<?php echo $_SERVER['SERVER_NAME']; ?>/ext/js/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");

</script> 

    <script type='text/javascript'> (function(d, w, m) { window.supportAPIMethod = m; var s = d.createElement('script'); s.type ='text/javascript'; s.id = 'supportScript'; s.charset = 'utf-8'; s.async = true; var id = '7080916fb9ef2018eab85d8dacb2d3ec'; s.src = '//me-talk.ru/support/support.js?h='+id; var sc = d.getElementsByTagName('script')[0]; w[m] = w[m] || function() { (w[m].q = w[m].q || []).push(arguments); }; if (sc) sc.parentNode.insertBefore(s, sc); else d.documentElement.firstChild.appendChild(s); })(document, window, 'MeTalk'); </script>
<noscript><div><img src="//mc.yandex.ru/watch/2570989" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php
/*----Adnous code------*/
/*
if ($PHP_SELF==FILENAME_PRODUCT_INFO){
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
<script type="text/javascript" src="http://cdn2.adnous.ru/1355.js"></script>
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

<?php
}*/

?>
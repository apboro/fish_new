<div class="away">
<div class="away_close"></div>
<form action="/contact_us.php?action=away" method="POST">
<input type="hidden" name="send_to" value="0">
<input type="hidden" name="name" value="away form">
<img class="cu" src="/templates/Original/images/content/contact_us.gif"/>
<table border="0">
<tr><td colspan="2" style="text-align:center">
<p>У нас для Вас есть специальное предложение, оставьте, пожалуйста, свой e-mail, что бы мы могли выслать его Вам</p>
</td></tr>
<tr><td colspan="2">
<input type="text" name="email" maxlength="43" placeholder="e-mail">
</td></tr>
<tr><td style="text-align:right;">
<img  src="captcha.php?t=<?php echo time(); ?>" alt="captcha" /></td><td>
<input name="captcha" type="text" size="10" maxlength="10" placeholder="число"></td></tr>
<input type="hidden" name="enquiry" value="away request">
<tr><td colspan="2" style="text-align: center;">
<img class="away_send" src="/templates/Original/images/buttons/russian/button_continue.gif" border="0" alt="Продолжить" title=" Продолжить ">
</td></tr>
</table>
</form>
</div>

<script type="text/javascript">
var away=1;
if (getCookie('AWM')==null){
jQuery(document).mouseleave(function () {
    if (away==1){
	jQuery("div.away").fadeIn(500);
    }
});
}
jQuery.fn.escape = function (callback) {
    return this.each(function () {
        $(document).on("keydown", this, function (e) {
            var keycode = ((typeof e.keyCode !='undefined' && e.keyCode) ? e.keyCode : e.which);
            if (keycode === 27) {
                callback.call(this, e);
            };
        });
    });
};
function hideAway(){setCookie('AWM',0);away=0;jQuery("div.away").fadeOut(500);}
jQuery("div.away").escape(function(){hideAway()});
jQuery("div.away_close").click(function(){hideAway();});
jQuery("img.away_send").click(function(){
	jQuery.post(
	      jQuery("div.away form").attr('action'),
	      jQuery("div.away form").serialize()
	    );
	hideAway();
	});
</script>

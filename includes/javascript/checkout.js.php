<?php
if (IS_MOBILE==0){?>
<script type="text/javascript" src="jscript/jquery/jquery.js"></script>
<?php
}
?>
<script type="text/javascript">
jQuery(document).ready(function() {
<?php
if (!tep_session_is_registered('customer_id')) {
?>
<?php if ((SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') && (($sc_is_virtual_product != true) || ($sc_is_mixed_product != true))) { ?>
jQuery(hidePw);
	function hidePw()	{
	if (jQuery("#pw_show").is(":checked") == '1')
		{
	jQuery("#pw_show").attr('checked', true);
	jQuery("#password_fields").css("display","none");
	}
	else
	{
	jQuery("#pw_show").attr('checked', false);
	}


	jQuery("#pw_show").click(function(){
// If checked
        if (jQuery("#pw_show").is(":checked"))
		{
            //show the hidden div
            jQuery("#password_fields").hide("fast");
        }
		else
		{
		jQuery("#password_fields").show("fast");
		}
	});
	;}

//});

<?php
	} // END password optional
?>


jQuery(hidePay);
	function hidePay()	{
	if (jQuery("#pay_show").is(":checked") == '1')
		{
	jQuery("#pay_show").attr('checked', true);
	jQuery("#payment_address").css("display","none");
	}
	else
	{
	jQuery("#pay_show").attr('checked', false);
	}


	jQuery("#pay_show").click(function(){
// If checked
        if (jQuery("#pay_show").is(":checked"))
		{
            //show the hidden div
            jQuery("#payment_address").hide("fast");
        }
		else
		{
		jQuery("#payment_address").show("fast");
		}
	});
	;}
<?php
    } //---end if loggedon
 ?>

jQuery(init);
function init()
	{
jQuery("div.tk").find('div').click(function(){
	jQuery('input[name=tk_type]').attr('checked',false);
	jQuery(this).find('input[type=radio]').attr('checked',true);
/*	tk_val=jQuery(this).find('input[type=radio]').val();
	jQuery('input[name=tk_type]').val([tk_val]);*/
//	jQuery('input[name="f_shipping"]').trigger('change');	
    });
jQuery('#box')
.on('change','input[name=f_shipping],input[name=shipping]',function(){
    jQuery("#f_shipping,#shipping").attr('value',jQuery('input[name=f_shipping]:checked,input[name=shipping]:checked').val());
    })
.on('change','input[name=f_payment]',function(){
    jQuery("#f_payment,#payment").attr('value',jQuery('input[name=f_payment]:checked').val());
    })

.on('change','input[name=tk_type]',function(){
    jQuery("#type_shipping").attr('value',jQuery('input[name=tk_type]:checked').val());
    jQuery("#f_shipping,#shipping").attr('value','tk_tk');
    })

}//---init

jQuery("#f_shipping,#shipping").attr('value',jQuery('input[name=f_shipping]:checked,input[name=shipping]:checked').val());
jQuery("#f_payment,#payment").attr('value',jQuery('input[name=f_payment]:checked').val());
jQuery("#type_shipping").attr('value',jQuery('input[name=tk_type]:checked').val());

});

var selected;
var c_url='checkout.php';
function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }
    ttype=jQuery(object).find('input').attr('name');
    if (ttype!='f_payment'){
jQuery("#ajax_loader").show();
    tselected=jQuery(object).find('input[name="f_shipping"]');
    if (typeof tselected !=='undefined'){
	if (jQuery(tselected).val()!='tk_tk'){
	    jQuery('input[name=tk_type]').attr('checked',false);
	    jQuery("#type_shipping").val('');
	    }
	    jQuery(tselected).attr('checked',true);

jQuery("input[name=tshipping]").val(jQuery('input[name=tk_type]:checked').val());
for (i=0;i<2;i++){
jQuery.post(c_url,{
     shipping: jQuery('input[name=shipping]:checked,input[name=f_shipping]:checked').val(),
     country: jQuery('select[name=country]').val(),
     state: jQuery('select[name=state]').val(),
     city: jQuery('input[name=city]').val(),
     postcode: jQuery('input[name=postcode]').val(),
     tshipping: jQuery('input[name=tk_type]:checked').val(),
     ajax: "true",
     ask : "shipping"
    }).done(function(data){
	if (i>0){
		jQuery("#payment_options").html(data);
    		jQuery("#f_payment").attr('value',jQuery('input[name=f_payment]:checked').val());
	    	jQuery("#ajax_loader").hide();
	    }
	});
    }//==for
	    //----place
	}
    }else{
    pselected=jQuery(object).find('input[name="f_payment"]');
    if (typeof pselected !=='undefined'){
	jQuery(pselected).attr('checked',true);
	jQuery(pselected).trigger('change');
	}
    }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;


// one button is not an array
if (typeof document.smart_checkout.payment!='undefined'){
      if (document.smart_checkout.payment[0]) {
        document.smart_checkout.payment[buttonSelect].checked=true;
     } else {
	document.smart_checkout.payment.checked=true;
    }
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow')
    {
    if (jQuery(object).attr('rel')!='tk'){object.className = 'moduleRowOver';}
    }
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

//--></script>
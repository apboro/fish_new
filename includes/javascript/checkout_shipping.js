<script type="text/javascript" src="jscript/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript"><!--
var selected;
$(document).ready(function(){
    if ($("input[name=shipping]:checked").val()!='tk_tk'){
         $("[name='tk_type']").attr('checked',false);
        }
    });

function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }
  st=document.checkout_address.shipping[buttonSelect].value;
  if (st!='tk_tk'){
     $("[name='tk_type']").attr('checked',false);
     }else{
	$(object).find('input[name=shipping]').attr('checked',true);
     }
  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;

// one button is not an array
  if (document.checkout_address.shipping[0]) {
    document.checkout_address.shipping[buttonSelect].checked=true;
  } else {
    document.checkout_address.shipping.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
//--></script>

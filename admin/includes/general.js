function SetFocus() {
  if (document.forms.length > 0) {
    var field = document.forms[0];
    for (i=0; i<field.length; i++) {
      if ( (field.elements[i].type != "image") &&
           (field.elements[i].type != "hidden") &&
           (field.elements[i].type != "reset") &&
           (field.elements[i].type != "submit") ) {

        document.forms[0].elements[i].focus();

        if ( (field.elements[i].type == "text") ||
             (field.elements[i].type == "password") )
          document.forms[0].elements[i].select();

        break;
      }
    }
  }
}

function rowOverEffect(object) {
  if (object.className == 'dataTableRow') object.className = 'dataTableRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'dataTableRowOver') object.className = 'dataTableRow';
}

function toggleDivBlock(id) {
  if (document.getElementById) {
    itm = document.getElementById(id);
  } else if (document.all){
    itm = document.all[id];
  } else if (document.layers){
    itm = document.layers[id];
  }

  if (itm) {
    if (itm.style.display != "none") {
      itm.style.display = "none";
    } else {
      itm.style.display = "block";
    }
  }
}


function orderSupplier(el) {
  var productInd = jQuery(el).attr('data-productind');
  var count = jQuery(el).closest('tr').find('[name="count"]').val();
  var orderId = jQuery(el).attr('data-orderid');
  var qty = jQuery(el).attr('data-qty');
    jQuery.ajax({
        type: 'GET',
        url: '/orderSupplier.php',
        data: {'count': count, 'product_ind': productInd, 'order_id': orderId},
        success: function (data) {
            jQuery(el).parent().html('Добавлено '+count+'<button  data-productind="'+productInd+'" data-orderid="'+orderId+'" data-qty="'+qty+'" onclick="deorderSupplier(this)">Отменить</button>');
        }
    });
}
function deorderSupplier(el) {
    var productInd = jQuery(el).attr('data-productind');
    var count = jQuery(el).closest('tr').find('[name="count"]').val();
    var orderId = jQuery(el).attr('data-orderid');
    var qty = jQuery(el).attr('data-qty');
    jQuery.ajax({
        type: 'GET',
        url: '/orderSupplier.php',
        data: {'action': 'deorder', 'count': count, 'product_ind': productInd, 'order_id': orderId},
        success: function (data) {
            jQuery(el).parent().html('<input  style="width:40px"   type="number" name="count" min="1" step="1" value="'+qty+'"><button  data-productind="'+productInd+'" data-qty="'+qty+'" data-orderid="'+orderId+'" onclick="orderSupplier(this)">Заказать</button>');
        }
    });
}
function priceProcessed(){
    jQuery.ajax({
        type: 'GET',
        url: '/orderSupplier.php',
        data: {'action': 'processed','supplier_id':jQuery('#order-supplier').val()},
    });
}

function changePriceType(item){
    jQuery('.types').hide();
    if(jQuery(item).val() !== ''){
        jQuery('.type-' + jQuery(item).val()).show();
    }
}
function updateSupplyPrices(form){
    var fd = new FormData(form);
    var text = $('.save-button').text();
    $('.save-button').text("Загрузка...");
    $('.save-button').addClass('btn-info');
    $.ajax({
        url: '/admin/priceupdate.php?action=update',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            $('.save-button').text(text);
            $('.save-button').removeClass('btn-info');
        }
    });
}
function changeSupplierPrice(select){
    if(jQuery(select).val() !== ''){
        var form = jQuery(select).closest('form');
        form.find('[name="type"],[name="number"],[name="file"],[name="link"],[name="article"]').val('');
        var option = jQuery(select).find('option:selected');
        form.find('[name="type"]').val(option.data('type'));
        jQuery('.types').hide();
        var file = option.data('file');
        console.log(file);
        if(option.data('type') == 'link'){
            form.find('[name="link"]').val(file);
        }else{
            form.find('.type-file > div').html(file);
        }
        form.find('[name="article"]').val(option.data('article'));
        jQuery('.type-' + option.data('type')).show();
    }
}

function startPriceUpdater(button){
    $(button).text("Обновление запущено").addClass('btn-info');
    $.ajax({
        url: '/update_stock.php',
        type: 'GET',
        success: function (data) {
            $$(button).text("Обновление успешно завершено").removeClass('btn-info');
        }
    });
}

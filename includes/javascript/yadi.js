<div id="yadi_div">
<fieldset style="float:left">
<legend>Получатель</legend>
<div><input type="text" name="name" placeholder="имя" id="ya_name"></div>
<div><input type="text" name="surname" placeholder="фамилия" id="ya_surname"></div>
<div><input type="text" name="city" placeholder="город" id="ya_city"></div>
<div><input type="text" name="house" placeholder="дом" id="ya_house"></div>
<div><input type="text" name="index" placeholder="индекс" id="ya_index"></div>
</fieldset>
<div><label data-ydwidget-open><input type="radio" name="delivery">Яндекс.Доставка</label></div>
<div id="ydwidget" class="yd-widget-modal"></div>
</div>
<script type="text/javascript">
 ydwidget.ready(function(){
    jQuery("#yadi_div").off('click');
    ydwidget.initCartWidget({
      // Получить указанный пользователем город.
      'getCity': function () {
        var city = yd$('#ya_city').val();
        if (city) {
          return {value: city};
        } else {
          return false;
        }
      },
      // id элемента-контейнера.
      'el': 'ydwidget',
      // Oбщее количество товаров в корзине.
      'totalItemsQuantity': function () { return cart.quantity },
      // Общий вес товаров в корзине.
      'weight': function () { return cart.weight },
      // Общая стоимость товаров в корзине.
      'cost': function () { return cart.cost },
    })
  })
</script>

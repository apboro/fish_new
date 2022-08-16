<link rel="stylesheet" type="text/css" href="/includes/javascript/city_auto.css">
<script src="https://api-maps.yandex.ru/2.1/?apikey=a10398eb-7d7f-43ff-a60f-3c7c71ec1978&lang=ru_RU" type="text/javascript"></script>
	//<script src="https://api-maps.yandex.ru/2.1/?apikey=406cb68d-5329-4eef-b1b9-b3b810d4c297&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
jQuery("input[name='oity']").prop( "disabled", true );
jQuery("input[name='oity']:first").prop( "disabled", false );
jQuery("input[name='oity']").addClass('ui-widget');
</script>
<script src="/ext/jquery/ui/jquery-ui-1.10.4.min.js" type="text/javascript"></script>


    <script type="text/javascript">
    jQuery("#postbox").change(function () {
        jQuery.ajax({
            url: '/cdek.php',
            data: {"cdek_postbox": jQuery("#postbox").val()},
            type: 'GET'
        });

    });
jQuery(function () {

    ymaps.ready(init);
    function init () {
        window.myMap = new ymaps.Map("yandmap", {
            center: [54.83, 37.11],
            zoom: 11
        }, {
            searchControlProvider: 'yandex#search'
        });
        window.blueCollection = new ymaps.GeoObjectCollection(null, {
            preset: 'islands#blueIcon'
        });
        myMap.geoObjects.add(blueCollection);

        if(jQuery("input[name='cityID']").val() !== '-1') {
            jQuery("input[name='oity']").data('ui-autocomplete')._trigger('select', 'autocompleteselect', {
                item: {
                    value: jQuery("input[name='oity']").val(),
                    id: jQuery("input[name='cityID']").val()
                }

            });
        }
    }
    if(jQuery('.checkout-mobile').length == 0) {
        jQuery("#showmap").fancybox({
            'width': 500,
            'height': 500,
            'autoScale': false,
            'modal': true,
            'onComplete': function () {
                jQuery('#fancybox-close').show();
            }
        });
    }
    window.selectPlace =  function($this){
    	var value = jQuery($this).data('value');
    	jQuery('#postbox').val(value);
    	//jQuery('#showmap').html($($this).data('addr'));
        jQuery.fancybox.close();
    	return false;
	};
    jQuery("input[name='oity']").autocomplete({
        source: function (request, response) {
            jQuery.ajax({							
                url: "https://api.cdek.ru/city/getListByTerm/jsonp.php?callback=?",
                dataType: "jsonp",
                crossDomain: true,
                appendTo: "input[name='oity']",
                data: {
                    q: function () {
                        return jQuery("input[name='oity']").val()
                    },
                    name_startsWith: function () {
                        return jQuery("input[name='oity']").val()
                    }
                },
				
                success: function (data) {
                    response(jQuery.map(data.geonames, function (item) {
                        return {
                            label: item.name,
                            value: item.cityName,
                            id: item.id,
                            postCodeArray: item.postCodeArray
                        }
                    }));
                }
            });
        },

        minLength: 1,
        select: function (event, ui) {
            if (jQuery("input[name='cityID']").length > 0) {
                jQuery("input[name='oity']").val(ui.item.value.substr(0, 30));
                jQuery("input[name='cityID']").val(ui.item.id);
                var s = jQuery("#postbox");
                jQuery(s).children().remove().end();
                jQuery.ajax({
                    url: '/cdek.php',
                    data: {"cityID": ui.item.id, "city": ui.item.value.substr(0, 30)},
                    type: 'GET',
                    dataType: "json",
                    success: function (data) {
                        if (data.error || !('addressList' in data)) {
                            alert("В данный населенный пункт невозможна доставка СДЭК, выберите, пожалуйста, другой способ доставки");
                        }
                        else {
                            jQuery("input[name='cityID']").parent().next().html(data.price + ' руб.');
                            jQuery("#cdek_way").html(data.period);
                            var center = [];
                            if(data.addressList.length > 0) {
                                blueCollection.removeAll()
                                jQuery.each(data.addressList, function (ind) {
                                    var item = this;
                                    var coord = [parseFloat(item.coordY), parseFloat(item.coordX)];
                                    if (ind == 0) {
                                        center = coord;
                                    }
                                    var myPlacemark = new ymaps.Placemark(coord, {
                                        // Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства.
                                        balloonContentHeader: "Пункт выдачи СДЭК",
                                        balloonContentBody: item.Address,
                                        balloonContentFooter: item.WorkTime + '<br><button onclick="selectPlace(this)" data-addr="' + item.Address + '" data-value="' + item.Code + '">Выбрать</button>',
                                    });
                                    blueCollection.add(myPlacemark);
                                });
                                myMap.setCenter(center);
                            }
                            jQuery(data.office).appendTo(s);
                            if(s.data('value') > ''){
                                var defaultOffice = s.data('value');
                                s.data('value','');
                                jQuery(s).find('option[value="'+defaultOffice+'"]').attr('selected','selected');;
                            }
                            selectRowEffect(s.closest('tr').click());
                            //$('#showmap').html($('#postbox option:selected').html());
                        }
			}
		    });

/*        jQuery.ajax({
			url : 'https://api.cdek.ru/calculator/calculate_price_by_jsonp.php',
			jsonp : 'callback',
			data : {
			    "json" : '{"version":"1.0","senderCityId":"44","receiverCityId":"'+ui.item.id+'","tariffList":[{"priority":"1","id":"136"},{"priority":"2","id":"137"},{"priority":"4","id":"10"},{"priority":5,"id":"11"}],"goods":[{"weight":"1","length":"20","width":"15","height":"10"}]}',
			},
			type : 'GET',
			dataType : "jsonp",
			success : function(data) 
				{
			    if(data.hasOwnProperty("result")) {
    					jQuery("input[name='cityID']").parent().next().html(data.result.price+' руб.');
				    if (data.result.tariffId=="10"){
					jQuery("#cdek_way").html('Склад-Склад');
					}
				    if (data.result.tariffId=="11"){
					jQuery("#cdek_way").html('Склад-Дверь');
					}
				    }
				}});
*/
/*		    jQuery.ajax({
			url : '/cdek.php',
			data : {
			     "cityID":ui.item.id,
			     "city":ui.item.value.substr(0,30),
			     "cdek_postbox":jQuery("#postbox").val()
			},
			type : 'GET'});
*/
}//---is selector
		    }
		});

    });
</script>
<div style="display:none;"><div id="yandmap" style="height:500px;width:500px;">

    </div></div>
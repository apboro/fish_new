
<center><H1 style = "font-size:20;">Рыболовный интернет-магазин на Черкизовской</h1><br></center>

<center><!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту  (начало) -->
<script src="http://api-maps.yandex.ru/1.1/?key=AF7JNEwBAAAAu77dJAIArN3CGHMVmOh9ZJIJJ-KVM7Jo-NoAAAAAAAAAAADbuhRpEQYu317PnmnvvZyf32FeyQ==&wizard=constructor" type="text/javascript"></script>
<script type="text/javascript">
    YMaps.jQuery(window).load(function () {
        var map = new YMaps.Map(YMaps.jQuery("#YMapsID-3719")[0]);
        map.setCenter(new YMaps.GeoPoint(37.750943,55.801942), 15, YMaps.MapType.MAP);
        map.addControl(new YMaps.Zoom());
        map.addControl(new YMaps.ToolBar());
        map.addControl(new YMaps.TypeControl());

        YMaps.Styles.add("constructor#FF3732c85Polyline", {
            lineStyle : {
                strokeColor : "FF3732c8",
                strokeWidth : 5
            }
        });
       map.addOverlay(createObject("Polyline", [new YMaps.GeoPoint(37.745232,55.802461),new YMaps.GeoPoint(37.745661,55.801349),new YMaps.GeoPoint(37.754717,55.80309),new YMaps.GeoPoint(37.753858,55.803573)], "constructor#FF3732c85Polyline", ""));

        function createObject (type, point, style, description) {
            var allowObjects = ["Placemark", "Polyline", "Polygon"],
                index = YMaps.jQuery.inArray( type, allowObjects),
                constructor = allowObjects[(index == -1) ? 0 : index];
                description = description || "";

            var object = new YMaps[constructor](point, {style: style, hasBalloon : !!description});
            object.description = description;

            return object;
        }
    });
</script>
<div id="YMapsID-3719" style="width:450px;height:350px"></div>
<div style="width:450px;text-align:right;font-family:Arial"></div><br>
<FORM>
<input TYPE="button" VALUE=" Печатать карту " ONCLICK="NewWindow()">
<script>
function NewWindow()
{
window.open("http://yourfish.ru/map2.htm","","");
}
</script>
</FORM>
<div itemscope itemtype="http://schema.org/LocalBusiness">
<span itemprop="name"><H1 style = "font-size:20;">Рыболовный интернет-магазин на Черкизовской</h1></span>

<br><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

<span itemprop="addressLocality">Москва</span>, <span itemprop="streetAddress"><h3>Щёлковское шоссе д.3 - Торговый Центр Глобус-Экстрим - 4 этаж, павильон 310</span>, <span itemprop="postalCode">115522</span>
</div>

 <br> Режим работы: <time itemprop="openingHours" datetime="Mo-Su">Ежедневно с 10:00 до 20:00</time><br>В магазине представлен ассортимент интернет-магазина. Цены в магазине и интернет-магазине могут отличаться!  <br>Наличие заранее уточняйте по телефонам: <br><span itemprop="telephone">+7-(495)-507-55-47<br>+7-(965)442-30-64</span><br>
 <div>Электронная почта: <span itemprop="email">magazin@yourfish.ru</span>
</div>
</div>
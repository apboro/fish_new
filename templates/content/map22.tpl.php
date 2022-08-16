<center><p style="font-size:20;">Рыболовный интернет-магазин на Черкизовской</p><br></center>

<center><!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту  (начало) -->
    <script src="https://api-maps.yandex.ru/1.1/?key=AF7JNEwBAAAAu77dJAIArN3CGHMVmOh9ZJIJJ-KVM7Jo-NoAAAAAAAAAAADbuhRpEQYu317PnmnvvZyf32FeyQ==&wizard=constructor"
            type="text/javascript"></script>
    <script type="text/javascript">
        YMaps.jQuery(window).load(function () {
            var map = new YMaps.Map(YMaps.jQuery("#YMapsID-3719")[0]);
            map.setCenter(new YMaps.GeoPoint(37.750943, 55.801942), 15, YMaps.MapType.MAP);
            map.addControl(new YMaps.Zoom());
            map.addControl(new YMaps.ToolBar());
            map.addControl(new YMaps.TypeControl());

            YMaps.Styles.add("constructor#FF3732c85Polyline", {
                lineStyle: {
                    strokeColor: "FF3732c8",
                    strokeWidth: 5
                }
            });
            map.addOverlay(createObject("Polyline", [new YMaps.GeoPoint(37.745232, 55.802461), new YMaps.GeoPoint(37.745661, 55.801349), new YMaps.GeoPoint(37.754717, 55.80309), new YMaps.GeoPoint(37.753858, 55.803573)], "constructor#FF3732c85Polyline", ""));

            function createObject(type, point, style, description) {
                var allowObjects = ["Placemark", "Polyline", "Polygon"],
                    index = YMaps.jQuery.inArray(type, allowObjects),
                    constructor = allowObjects[(index == -1) ? 0 : index];
                description = description || "";

                var object = new YMaps[constructor](point, {style: style, hasBalloon: !!description});
                object.description = description;

                return object;
            }
        });
    </script>
    <script type="text/javascript" charset="utf-8" async
            src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=5obso6b2UvIMaTvf8EhNQNGRb-Zl8f6x&amp;width=603&amp;height=522&amp;lang=ru_RU&amp;sourceType=mymaps&amp;scroll=true"></script>
    <FORM>
        <input TYPE="button" VALUE=" Печатать карту " ONCLICK="NewWindow()">
        <script>
            function NewWindow() {
                window.open("<?php echo echoHTTP();?>yourfish.ru/map2.htm", "", "");
            }
        </script>
    </FORM>
    <?php
    global $regions;
    ?>
    <div itemscope itemtype="http://schema.org/LocalBusiness">
        <H1 style="font-size:20;"><span itemprop="name">Рыболовный интернет-магазин на Черкизовской</span></h1>

        <br>
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

            <h3><span itemprop="addressLocality"><?=$regions->showCurrentParam('name')?></span>,
                <span itemprop="streetAddress"><?=$regions->showCurrentParam('address')?></span>,
                <span itemprop="postalCode"><?=$regions->showCurrentParam('postalCode')?></span>
        </div>

        <br> Режим работы:
        <time itemprop="openingHours" datetime="Mo-Su">Ежедневно с 10:00 до 20:00</time>
        <br>В магазине представлен ассортимент интернет-магазина. Цены в магазине и интернет-магазине могут отличаться!
        <br>Наличие заранее уточняйте по телефонам: <br><span itemprop="telephone">+7(495)-507-55-47<br>8(800)-222-41-49</span><br>
        <div>Электронная почта: <span itemprop="email">magazin@yourfish.ru</span>
            </h3>
        </div>
    </div>


    <br>

    <br><br><br><br><br><br><br><!--
<div style="margin-bottom: 5px;"><a style="font-size: 11px; color: #a9a9a9;" onclick="document.getElementById('maintext').style.display = document.getElementById('maintext').style.display == 'block' ? 'none':'block'; return false;" href="javascript:void();">Подразделения</a></div>
<div id="maintext" class="maintext" style="display: block;">

<div itemscope itemtype="http://schema.org/LocalBusiness">
<H1 style = "font-size:20;"><span itemprop="name">Рыболовный интернет-магазин Новосибирск</span></h1>

<br><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

<h3><span itemprop="addressLocality">Новосибирск</span>, <span itemprop="streetAddress">Улица Советская, дом 32</span>, <span itemprop="postalCode">630000</span>
</div>

 <br> Режим работы: <time itemprop="openingHours" datetime="Mo-Su">Ежедневно с 10:00 до 20:00</time><br>В магазине представлен ассортимент интернет-магазина. Цены в магазине и интернет-магазине могут отличаться!  <br>Наличие заранее уточняйте по телефонам: <br><span itemprop="telephone">+7-(495)-507-55-47<br>+7-(965)442-30-64</span><br>
 <div>Электронная почта: <span itemprop="email">magazin@yourfish.ru</span>
  <span itemprop="logo"><?php echo echoHTTP(); ?>yourfish.ru/templates/Original/images/content/default.gif</span>
 <span itemprop="url"><?php echo echoHTTP(); ?>yourfish.ru</span></h3>
</div>
</div>

<div itemscope itemtype="http://schema.org/LocalBusiness">
<H1 style = "font-size:20;"><span itemprop="name">Рыболовный интернет-магазин Екатеринбург</span></h1>

<br><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

<h3><span itemprop="addressLocality">Екатеринбург</span>, <span itemprop="streetAddress">ул. Попова, д. 6</span>, <span itemprop="postalCode">620014</span>
</div>

 <br> Режим работы: <time itemprop="openingHours" datetime="Mo-Su">Ежедневно с 10:00 до 20:00</time><br>В магазине представлен ассортимент интернет-магазина. Цены в магазине и интернет-магазине могут отличаться!  <br>Наличие заранее уточняйте по телефонам: <br><span itemprop="telephone">+7-(495)-507-55-47<br>+7-(965)442-30-64</span><br>
 <div>Электронная почта: <span itemprop="email">magazin@yourfish.ru</span>
  <span itemprop="logo"><?php echo echoHTTP(); ?>yourfish.ru/templates/Original/images/content/default.gif</span>
 <span itemprop="url"><?php echo echoHTTP(); ?>yourfish.ru</span></h3>
</div>
</div>


<div itemscope itemtype="http://schema.org/LocalBusiness">
<H1 style = "font-size:20;"><span itemprop="name">Рыболовный интернет-магазин Псков</span></h1>

<br><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

<h3><span itemprop="addressLocality">Псков</span>, <span itemprop="streetAddress">ул.Советская, д.8</span>, <span itemprop="postalCode">180000</span>
</div>

 <br> Режим работы: <time itemprop="openingHours" datetime="Mo-Su">Ежедневно с 10:00 до 20:00</time><br>В магазине представлен ассортимент интернет-магазина. Цены в магазине и интернет-магазине могут отличаться!  <br>Наличие заранее уточняйте по телефонам: <br><span itemprop="telephone">+7-(495)-507-55-47<br>+7-(965)442-30-64</span><br>
 <div>Электронная почта: <span itemprop="email">magazin@yourfish.ru</span>
 <span itemprop="logo"><?php echo echoHTTP(); ?>yourfish.ru/templates/Original/images/content/default.gif</span>
 <span itemprop="url"><?php echo echoHTTP(); ?>yourfish.ru</span></h3>
</div>
</div>





<p>
<script type="text/javascript">// <![CDATA[
 document.getElementById('maintext').style.display = 'none';
// ]]>
// ]]></script>
</p> -->
<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require(DIR_WS_INCLUDES . 'counter.php');
    $new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, pd.products_description, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit 3");
$num_new_products = tep_db_num_rows($new_products_query); ?>
</div>
</div>
<?php 
    $cat_slide = tep_db_query("select * from manufacturers ORDER BY RAND() LIMIT 5");

?>
<?php 
	
	if((basename($PHP_SELF) == FILENAME_DEFAULT && $cPath == '') && !isset($_GET['manufacturers_id']))
	{
?>				
<div id="mj-footertop">
	<div class="mj-subcontainer">
<?php /* ?>
    	<div class="mj-brands mj-grid56 mj-lspace mj-rspace">
        	<h3><?php echo TEXT_OUR_BRANDS; ?> </h3>
            		<div id="wrapper">
			<div id="carousel">

						<ul>
                        	<?php 
							  while($manufactureimage = tep_db_fetch_array($cat_slide)){
						$img = $manufactureimage['manufacturers_image'];
							?>
                        	<li><img loading="auto" src="images/<?php echo $img;?>" alt="IMG" /></li>
						<?php	} ?>
						</ul>
                        				<div class="clearfix"></div>
				<a id="prev" class="prev" href="#">&lt;</a>
				<a id="next" class="next" href="#">&gt;</a>
                   </div>
                   </div>     
		</div>
<?php */?>	       	
<?php /* ?> 
        <div class="mj-stayintouch mj-grid40 mj-lspace mj-rspace">
        		<h3><?php echo TEXT_STAY_IN_TOUCH; ?></h3>
                <div class="mj-newsletter">
                        <a class="mj-newstext" href="<?php echo tep_href_link('newsletter.php')?>"><?php echo TEXT_JOIN_OUR_NEWSLETTER; ?></a>
                        <p><?php echo TEXT_STAY_UPDATED_WITH_OFFRES_AND_NEW_ARRIVALS;  ?></p>
                </div>
                <div class="mj-storelocator mj-lspace mj-rspace">
                    <a class="mj-storetext" href="<?php echo tep_href_link('store_finder.php')?>"><?php echo TEXT_STORE_FINDER; ?></a>
                    <p><?php echo TEXT_FIND_STORE_NEAR_TO_YOU;  ?></p>
                </div>
         	</div>
         <?php */ ?>
    </div>
</div> <?php } ?>


<div id="mj-footer">
	<div class="mj-subcontainer">
<?php /* ?>
 <!-- Latest Products in footer -->
<!--
        <div class="moduletable mj-grid24 mj-dotted">
        	<h3><?php echo TEXT_LATEST_PRODUCTS;  ?></h3>
        	<div class="custom mj-grid24 mj-dotted mj-latest">
            	<ul class="mj-product">
                	<?php
                	while ($new_products = tep_db_fetch_array($new_products_query)) { ?>
                    <?php 
							$products_description = $new_products['products_description'];	
							$products_description = ltrim(mb_substr($products_description, 0, 30,'utf-8') . '...<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">'.TEXT_MORE.'</a>'); //Trims and Limits the desc ?>
                	<li>
                    	<?php echo '<div class="footer_productinfo"><div class="mj-latestimage">' . '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">'. tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>'; ?>
                        <?php echo '<div class="mj-productname">' . '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">'. $new_products['products_name'] . '</a></div>'; ?>
                        <?php echo '<div class="mj-productdescription">' . $products_description . '</div></div>'; ?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div> 
        -->
        <!-- Latest Products in footer ends -->
<?php */ ?>
<?php /*?>
        <div class="moduletable mj-grid24 mj-dotted"> <!-- Extra in footer -->
        	<h3><?php echo TEXT_EXTRA; ?></h3>
            	<div class="custom mj-grid24 mj-dotted">
                   <ul class="footer-bullet">
                    <li><a href="<?php echo tep_href_link('about_us.php')?>"><?php echo TEXT_ABOUT_US;  ?><i class="fa fa-arrow-circle-o-right"></i></a></li>
                    <li><a href="<?php echo tep_href_link('terms_condition.php')?>"><?php echo TEXT_TERMS_AND_CONDITION;  ?><i class="fa fa-arrow-circle-o-right"></i></a></li>
                    <li><a href="<?php echo tep_href_link('privacy.php')?>"><?php echo TEXT_PRIVACY_POLICY;  ?><i class="fa fa-arrow-circle-o-right"></i></a></li>
                    <li><a href="<?php echo tep_href_link('refund_policy.php')?>"><?php echo TEXT_REFUND_POLICY;  ?><i class="fa fa-arrow-circle-o-right"></i></a></li>
                    <li><a href="<?php echo tep_href_link('sitemap.php')?>"><?php echo TEXT_SITEMAP;  ?><i class="fa fa-arrow-circle-o-right"></i></a></li>
                    <li><a href="<?php echo tep_href_link('affiliates.php')?>"><?php echo TEXT_AFFILIATES;  ?><i class="fa fa-arrow-circle-o-right"></i></a></li>
                    <li><a href="<?php echo tep_href_link('delivery_information.php')?>"><?php echo TEXT_DELIVERY_INFORMATION;  ?><i class="fa fa-arrow-circle-o-right"></i></a></li>
                    </ul>
	</div>
        </div> <!-- Extra in footer ends -->
<?php */?>
        <div class="moduletable mj-grid40 mj-dotted"> 
        	<h3><?php echo TEXT_GET_IN_TOUCH;  ?></h3>
            <div class="custom mj-grid40 mj-dotted">
                <div class="address">
                	<i class="fa fa-home fa-3x"></i>
                    <span  style="display:inline-block;margin: -14px 45px 10px;" class="small" ><?php echo OSMARTVAL_ADDRESS;  ?></span>
                    <br/>
                    <span class="small_txt"><?php echo TEXT_FIND_US_ON_MAP;  ?></span>
                </div>            
                <div class="mail">
                	 <i class="fa fa-envelope-o fa-3x"></i>
                    <span class="small"><?php echo TEXT_EMAIL_US_AT;  ?></span>
                    <br/>
                    <span class="small_txt"><a href="mailto:<?php echo OSMARTVAL_EMAIL_US_AT; ?>"><?php echo OSMARTVAL_EMAIL_US_AT;  ?></a></span>
                </div>
<!--                <div class="phone">-->
<!--                <i style="text-align:center;" class="fa fa-mobile fa-4x"></i>-->
<!--                    <span class="small">--><?php //echo TEXT_27_7_PHONE_SUPPORT;  ?><!--</span>-->
<!--                    <br/>-->
<!--                   <span class="small_txt"> --><?php //echo OSMARTVAL_PHONE;  ?><!--</span>-->
<!--                </div>-->
                <!-- <div class="skype">
                	<i class="fa fa-skype fa-3x"></i>
                    <span class="small"><?php //echo TEXT_TALK_TO_US;  ?></span>
                    <br/>
                    <span class="small_txt"><?php //echo OSMARTVAL_SKYPE;  ?></span>
                </div>  -->
                <div class="icq">
                	<i class="fa fa-3x fa-icq"></i>
                    <span class="small"><?php echo TEXT_ICQ_TO_US;  ?></span>
                    <br/>
                    <span class="small_txt"><?php echo OSMARTVAL_ICQ;  ?></span>
                </div> 
                <div class="delivery">
                	<i class="fa fa-3x fa-truck"></i>
                    <span class="small"><?php echo TEXT_FOOTER_DELIVERY_TITLE;  ?></span>
                    <br/>
                    <span class="small_txt"><?php echo TEXT_FOOTER_DELIVERY;  ?></span>
                </div> 
                
                
<?php  ?>                
              <div class="social_icons">
                   <a href="<?php echo SOCIAL_VK_A; ?>"><i class="fa fa-vk fa-3x"></i></a>
                   <a  href="<?php echo SOCIAL_YOUTUBE_A; ?>"><i class="fa fa-youtube fa-3x"></i></a>
                   <a href="<?php echo SOCIAL_TWITTER_A; ?>"><i class="fa fa-tumblr-square fa-3x"></i></a>
                </div>
<?php  ?>
            </div>
        </div>
	</div>
</div>
</div>
<div id="mj-copyright"> 
        <div class="mj-subcontainer"> 
                <div class="custom mj-grid88" style="text-align:justify">
<p class="copyright">&copy;<a href="/">Рыболовный интернет магазин </a>YourFish.ru, 2008-2021.
<br>
Москва, 4-й Лихачевский переулок д2 с2 WhatsApp: <a href=https://wa.me/79262663218> написать в чат </a>
<br>    Обращаем ваше внимание на то, что данный интернет-сайт носит исключительно информационный
    характер и ни при каких условиях не является публичной офертой, определяемой положениями
    Статьи 437 (2) Гражданского кодекса Российской Федерации.
    Для получения подробной информации о наличии и стоимости указанных товаров и (или) услуг,
    пожалуйста, обращайтесь к менеджеру сайта с помощью специальной формы связи или по WhatsApp.<br>
В рыболовном интернет магазине доставка почтой рыболовных снастей осуществляется также в следующие регионы России: Москва, Санкт-Петербург, Новосибирск, Екатеринбург, Нижний Новгород, Казань, Самара, Омск, Челябинск, Ростов-на-Дону, Уфа, Волгоград, Красноярск, Пермь, Воронеж, Саратов, Краснодар, Тольятти, Барнаул, Ульяновск, Тюмень, Ижевск, Иркутск, Владивосток, Хабаровск, Улан-Удэ, Подольск, Салехард, Тверь, Сочи, Псков, Петрозаводск, Мурманск.
</p>
                <div class="custom mj-grid8">
                    <p>
                        <a id="w2b-StoTop" class="top" style="display: block;"><?php echo TEXT_BACK_TO_TOP;  ?></a>
                    </p>
                </div>
        </div> 
    </div> 
</div>
<script src="/ext/js/es5-shims.min.js" async></script>
<script src="/ext/js/share.js" async></script>
<div class="ya-share2" data-services="facebook,vkontakte,twitter,gplus,whatsapp,skype,odnoklassniki,moimirblogger,delicious,digg,reddit,linkedin,lj,viber,telegram" data-direction="horizontal" data-limit="6" data-size="m"></div>

<?php
if (isset($javascript_footer)){
    if (is_array($javascript_footer)){
    foreach($javascript_footer as $script){
    if (file_exists(DIR_FS_CATALOG.DIR_WS_JAVASCRIPT .basename($script)))
        { require(DIR_FS_CATALOG.DIR_WS_JAVASCRIPT .basename($script)); }
        }
        }else{
        if (file_exists(DIR_FS_CATALOG.DIR_WS_JAVASCRIPT .basename($javascript_footer)))
            { require(DIR_FS_CATALOG.DIR_WS_JAVASCRIPT .basename($javascript_footer)); }
            }
    }
?>
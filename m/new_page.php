<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEW_PAGE);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_NEW_PAGE, '', 'NONSSL'));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div id="mj-shippingreturns">
<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
    <div id="mj-content">
<div class="item-page">
<div class="mj-full mj-dotted">
<p>
<img border="0" align="right" alt="about" src="./images/pages.png">
Quod est diuturni et distraherentur readable contineatur pagina lector eius quaerentes elit. Punctum utendi Lorem ipsum est quod habet-vel-minus normalis distributio litteras, ut opponitur ad usura 'Content hic, contentus hic, faciens eam tamquam readable Latin.Quod est diuturni et distraherentur readable contineatur pagina lector eius quaerentes elit. Punctum utendi Lorem ipsum est quod habet-vel-minus normalis distributio litteras, ut opponitur ad usura 'Content hic, contentus hic, faciens eam tamquam readable Latin.
</p>
</div>
<div class="mj-full mj-dotted">
<h3>Our Team</h3>
<p class="mj-dropcap">Quod est diuturni et distraherentur readable contineatur pagina lector eius quaerentes elit. Punctum utendi Lorem ipsum est quod habet-vel-minus normalis distributio litteras, ut opponitur ad usura 'Content hic, contentus hic, faciens eam tamquam readable Latin.Quod est diuturni et distraherentur readable contineatur pagina lector eius quaerentes elit. Punctum utendi Lorem ipsum est quod habet-vel-minus normalis distributio litteras, ut opponitur ad usura 'Content hic, contentus hic, faciens eam tamquam readable Latin.</p>
</div>
<p> </p>
<div class="mj-full mj-dotted">
<div class="mj-grid48">
<h3>steve</h3>
<p>
<img border="0" align="right" alt="John Doe" src="./images/user_1.png">
Quod est diuturni et distraherentur readable contineatur pagina lector eius quaerentes elit.
</p>
</div>
<div class="mj-grid48">
<h3>Martin</h3>
<p>
<img border="0" align="right" alt="John Doe" src="./images/user_2.png">
Quod est diuturni et distraherentur readable contineatur pagina lector eius quaerentes elit.
</p>
</div>
</div>
<div class="mj-full mj-dotted">
<div class="mj-grid48">
<h3>Rebecca</h3>
<p>
<img border="0" align="right" alt="John Doe" src="./images/user_3.png">
Quod est diuturni et distraherentur readable contineatur pagina lector eius quaerentes elit.
</p>
</div>
<div class="mj-grid48">
<h3>stone</h3>
<p>
<img border="0" align="right" alt="John Doe" src="./images/user_4.png">
Quod est diuturni et distraherentur readable contineatur pagina lector eius quaerentes elit.
</p>
</div>
</div>
</div>
</div>
</div>
  
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>

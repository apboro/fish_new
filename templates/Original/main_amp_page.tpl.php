<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?> amp>
<head><meta charset="UTF-8">
    <link rel="shortcut icon" href="favicon.ico">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'/>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'/>
    <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <?php
    // BOF: WebMakers.com Changed: Header Tag Controller v1.0
    // Replaced by header_tags.php
    if (file_exists(DIR_WS_INCLUDES . 'header_tags.php')) {
        require(DIR_WS_INCLUDES . 'header_tags.php');
    } else {
        ?>
        <title><?php echo TITLE ?></title>
        <?php
    }
    // EOF: WebMakers.com Changed: Header Tag Controller v1.0
    ?>

    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <style amp-custom>
        body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, fieldset, input, textarea, p, blockquote, th, td {
            margin: 0;
            padding: 0;
        }

        a {
            outline: none;
            font-weight: normal;
            transition: all 0.3s ease-in 0s;
            -moz-transition: all 0.3s ease-in 0s;
            -webkit-transition: all 0.3s ease-in 0s;
            -o-transition: all 0.3s ease-in 0s;
            -ms-transition: all 0.3s ease-in 0s;
        }

        a {
            text-decoration: none;
        }

        #mj-container {
            width: 100%;
        }

        #mj-topbar {
            text-transform: uppercase;
            margin-bottom: 0px;
            background: url("/ext/images/topbar-bg.png") 0px 0px repeat scroll rgb(54, 146, 202);
            font-size: 12px;
            font-family: Oswald, sans-serif;
            padding: 10px 0 9px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2) inset;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
        }

        #mj-topbar * {
            color: #fff;
        }

        #mj-topbar, #mj-header, #mj-navigation, #mj-slideshow, #mj-featured1, #mj-featured2, #mj-featured3, #mj-featured4, #mj-maincontent, #mj-footer, #mj-copyright {
            float: left;
            display: inline;
            width: 100%;
        }

        #headerShortcuts {
            float: right;
            margin-top: 0;
        }

        #mj-topbar .menu {
            float: right;
        }

        #mj-topbar li {
            float: left;
            padding: 0 0px 0 10px;
        }

        .breadcrumb_addon {
            display: inline-block;
            text-align: center;
            background: transparent url(/ext/images/menu-bg.png) repeat-x scroll 0 0;
            float: left;
            width: 100%;
            padding-top: 7px;
            margin: 0;
        }

        #mj-menubar .btn {
            background: #151515;
            border: none;
            outline: none;
        }

        #mj-righttop {
            background: url(/ext/images/menu-bg.png) repeat-x scroll 0 0 transparent;
            float: left;
            width: 100%;
        }

        #mj-maincontent {
            padding: 0px;
        }

        #mj-topbar, #mj-header, #mj-navigation, #mj-slideshow, #mj-featured1, #mj-featured2, #mj-featured3, #mj-featured4, #mj-maincontent, #mj-footer, #mj-copyright {
            float: left;
            display: inline;
            width: 100%;
        }

        div.CLB {
            display: inline-block;
            width: 100%;
        }

        @media only screen and (min-width: 702px) {
            .CLB div.categoryListBoxContents {
                width: 19%;
            }
        }

        .CLB div.categoryListBoxContents {
            margin: 2px;
            width: 130px;
            height:203px;
            overflow: hidden;
        }

        .subproduct_name {
            padding: 10px;
            font-size: 16px;
            text-transform: uppercase;
        }

        #mj-logo a, .product_head, .product_title, .product_price strong, span.title, .jsn-mainnav.navbar .nav > li > a, .jsn-mainnav.navbar .nav > li ul.nav-child li a, .mj-headcolor, .add_title, #mj-menu a, #mj-menu .mj-submenu li a, #mj-menu .mj-submenu ul.mj-text li, a:visited, a, .prodprice, .navNextPrevList a, .buttonRow .rightBoxContainer a, #cartProdTitle, .cartBoxTotal, #mj-right li a, .product_name a, .subproduct_name a, #mj-topbar .mj-grid16, .navbar .nav > li > a:hover, .navbar .nav > li > a:active, .breadcrumbs, #navBreadCrumb a:hover {
            color: #3692CA;
        }

        a:hover, a:active {
            outline: 0 none;
        }

        #mj-slideshow img, .mj-subcontainer table, a img, .mj-latest ul:first-child {
            border: none;
        }

        #new_catalog {
            font-family: 'Oswald', sans-serif;
            display: inline-block;
            position: relative;
            float: left;
            width: 100%;
            background: hsla(0, 0%, 0%, 0) url(/ext/images/sidebox-bg.png) repeat-x scroll 0 0;
            border-color: -moz-use-text-color -moz-use-text-color hsl(0, 0%, 85%);
            border-style: none none solid;
            border-width: medium medium 1px;
        }

        div.new_cat_menu {
            position: absolute;
            left: 2px;
            top: -15px;
            display: none;
            float: left;
            width: auto;
            text-align: left;
            z-index: 9998;
        }

        .mj-subcontainer {
            margin: 0 auto;
            width: 92%;
            position: relative;
        }

        #mj-menubar {
            float: left;
            width: 100%;
        }

        #mj-menubar .jsn-mainnav.navbar {
            margin-bottom: 0;
        }

        .navbar {
            color: #999999;
        }

        @font-face {
            font-family: 'FontAwesome';
            src: url('/ext/css/font-awesome/fonts/fontawesome-webfont.eot');
            src: url('/ext/css/font-awesome/fonts/fontawesome-webfont.eot') format('embedded-opentype'), url('/ext/css/font-awesome/fonts/fontawesome-webfont.woff?v=4.2.0') format('woff'), url('/ext/css/font-awesome/fonts/fontawesome-webfont.ttf?v=4.2.0') format('truetype'), url('/ext/css/font-awesome/fonts/fontawesome-webfont.svg?v=4.2.0#fontawesomeregular') format('svg');
            font-weight: normal;
            font-style: normal
        }

        .fa-home:before {
            content: "\f015"
        }

        .fa-envelope-o:before {
            content: "\f003";
        }

        .fa-mobile-phone:before, .fa-mobile:before {
            content: "\f10b";
        }

        .fa-skype:before {
            content: "\f17e";
        }

        .fa-icq {
            background-image: url(/ext/images/icq.png);
            width: 48px;
            height: 48px;
        }

        .fa-truck:before {
            content: "\f0d1";
        }

        .fa-vk:before {
            content: "\f189";
        }

        .fa-youtube:before {
            content: "\f167";
        }

        .fa-tumblr-square:before {
            content: "\f174";
        }

        .fa-check-circle:before {
            content: "\f058";
        }

        .fa-shopping-cart:before {
            content: "\f07a";
        }

        .fa-sign-in:before {
            content: "\f090";
        }

        .fa {
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .fa-lg {
            font-size: 1.33333333em;
            line-height: .75em;
            vertical-align: -15%
        }

        .fa-2x {
            font-size: 2em
        }

        .fa-3x {
            font-size: 3em
        }

        .fa-4x {
            font-size: 4em
        }

        .fa-5x {
            font-size: 5em
        }

        .fa-fw {
            width: 1.28571429em;
            text-align: center
        }

        .fa-ul {
            padding-left: 0;
            margin-left: 2.14285714em;
            list-style-type: none
        }

        .fa-ul > li {
            position: relative
        }

        .fa-li {
            position: absolute;
            left: -2.14285714em;
            width: 2.14285714em;
            top: .14285714em;
            text-align: center
        }

        .fa-li.fa-lg {
            left: -1.85714286em
        }

        .fa-border {
            padding: .2em .25em .15em;
            border: solid .08em #eee;
            border-radius: .1em
        }

        .pull-right {
            float: right
        }

        .pull-left {
            float: left
        }

        .fa.pull-left {
            margin-right: .3em
        }

        .fa.pull-right {
            margin-left: .3em
        }

        body {
            font-family: 'PT Sans', sans-serif;
            color: #404040;
            font-size: 14px;
        }

        .navbar-inner {
            min-height: 40px;
            background-image: url(/ext/images/gradient-header-bg.png);
            background: none repeat scroll 0 0 transparent;
            background-image: -moz-linear-gradient(top, #333333, #222222);
            background-image: -ms-linear-gradient(top, #333333, #222222);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#333333), to(#222222));
            background-image: -webkit-linear-gradient(top, #333333, #222222);
            background-image: -o-linear-gradient(top, #333333, #222222);
            background-image: linear-gradient(top, #333333, #222222);
            background-repeat: repeat-x;
            -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        }

        .jsn-mainnav .jsn-mainnav-inner {
            background: none;
            box-shadow: none;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
        }

        .navbar .container {
            width: auto;
        }

        html[xmlns] .clearfix {
            display: block;
        }

        .clearfix:before, .clearfix:after {
            display: table;
            content: "";
        }

        .clearfix {
            float: none;
            clear: both;
        }

        @media (min-width: 980px) {
            .nav-collapse.collapse {
                height: auto ;
                overflow: visible ;
            }
        }

        .navbar ul.nav {
            position: relative ;
            left: 0 ;
            display: block ;
            margin: 0 0px 0 0;
        }

        .navbar .nav > li {
            display: block;
            float: left;
        }

        .jsn-mainnav.navbar .nav > li:hover {
            background-color: #E5E5E5;
            cursor: pointer;
        }

        .jsn-mainnav.navbar .nav > li {
            position: relative;
        }

        .navbar .nav > li {
            margin-left: -1px;
        }

        #jsn-pos-mainnav li a {
            box-sizing: unset;
        }

        .jsn-mainnav.navbar .nav-collapse > ul.nav li a:hover {
            color: hsl(217, 16%, 35%);
        }

        .jsn-mainnav.navbar .nav-collapse ul.nav li a {
            background: #F2F2F2 ;
            text-shadow: none;
            color: #4B5668;
        }

        #mj-logo a, .product_head, .product_title, .product_price strong, span.title, .jsn-mainnav.navbar .nav > li > a, .jsn-mainnav.navbar .nav > li ul.nav-child li a, .mj-headcolor, .add_title, #mj-menu a, #mj-menu .mj-submenu li a, #mj-menu .mj-submenu ul.mj-text li, a:visited, a, .prodprice, .navNextPrevList a, .buttonRow .rightBoxContainer a, #cartProdTitle, .cartBoxTotal, #mj-right li a, .product_name a, .subproduct_name a, #mj-topbar .mj-grid16, .navbar .nav > li > a:hover, .navbar .nav > li > a:active, .breadcrumbs, #navBreadCrumb a:hover {
            color: #3692CA;
        }

        .jsn-mainnav.navbar .nav > li > a {
            padding: 10px 20px;
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            text-transform: uppercase;
            text-shadow: 0 1px 0 #fff;
            transition: 0.3s;
            -moz-transition: 0.3s;
            -webkit-transition: 0.3s;
        }

        #mj-maincontent .mj-grid16 {
            width: 15.866%;
        }

        .categoryListBoxContents {
            display: inline-block;
            min-height: 240px;
            border-radius: 5px 5px 5px 5px;
            float: left;
        }

        .centeredContent, TH, #cartEmptyText, #cartBoxGVButton, #navNextPrevWrapperTop, #navNextPrevWrapperBottom, #navCatTabsWrapper, #navEZPageNextPrev, #bannerOne, #bannerTwo, #bannerThree, #bannerFour, #bannerFive, #bannerSix, #siteinfoLegal, #siteinfoCredits, #siteinfoStatus, #siteinfoIP, .center, .cartRemoveItemDisplay, .cartQuantityUpdate, .cartQuantity, .cartTotalsDisplay, #cartBoxGVBalance, .accountQuantityDisplay, .ratingRow, LABEL#textAreaReviews, .productMainImage, .mj-reviewsProductImage, #productReviewsDefaultProductImage, .review_writeimage, .centerBoxContents, .specialsListBoxContents, .categoryListBoxContents, .additionalImages, .centerBoxContentsSpecials, .centerBoxContentsAlsoPurch, .centerBoxContentsFeatured, .centerBoxContentsNew, .gvBal, .attribImg {
            text-align: center;
        }

        .centerBoxContents, .specialsListBoxContents, .categoryListBoxContents, .additionalImages, .centerBoxContentsSpecials, .centerBoxContentsAlsoPurch, .centerBoxContentsFeatured, .centerBoxContentsNew {
            margin: 0;
        }

        #contentColumnMain, #navColumnOne, #navColumnTwo, .centerBoxContents, .specialsListBoxContents, .categoryListBoxContents, .additionalImages, .centerBoxContentsSpecials, .centerBoxContentsAlsoPurch, .centerBoxContentsFeatured, .centerBoxContentsNew, .alert {
            vertical-align: top;
        }

        .centerBoxContentsNew.centeredContent, .centerBoxContentsFeatured.centeredContent, .centerBoxContentsSpecials.centeredContent, .productListing-odd, .productListing-even, .categoryListBoxContents {
            border: 1px solid #D9D9D9;
            margin-bottom: 23px;
        }

        .centerBoxContentsNew.centeredContent:hover, .centerBoxContentsFeatured.centeredContent:hover, .centerBoxContentsSpecials.centeredContent:hover, .productListing-odd:hover, .productListing-even:hover, .categoryListBoxContents:hover {
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            -moz-transition: all 0.5s ease 0s;
            -webkit-transition: all 0.5s ease 0s;
            -o-transition: all 0.5s ease 0s;
            -ms-transition: all 0.5s ease 0s;
        }

        #mj-maincontent .mj-grid16 {
            width: 15.866%;
        }

        #mj-left, #mj-right, td .mj-boxcontent {
            text-shadow: none;
        }

        .mj-grid8, .mj-grid16, .mj-grid24, .mj-grid32, .mj-grid40, .mj-grid48, .mj-grid56, .mj-grid64, .mj-grid72, .mj-grid80, .mj-grid88, .mj-grid96 {
            float: left;
            margin-left: 1%;
            margin-right: 1%;
        }


        #mj-contentarea, #mj-right {
            float: right;
        }

        .ui-widget-header.infoBoxHeading {
            background: url(/ext/images/sidebox-bg.png) repeat-x scroll 0 0 transparent;
            padding: 10px;
            border-bottom: 1px solid #D8D8D8;
            font-size: 16px;
            font-family: Oswald, Sans-serif;
            text-transform: uppercase;
        }

        ul.tabs li.selected a, h3.rightBoxHeading, h3.leftBoxHeading, .alternate_text, .ui-widget-header a, .ui-widget-header.infoBoxHeading {
            color: #3692CA;
        }

        #mj-maincontent .ui-widget-header {
            background: url(/ext/images/sidebox-bg.png) repeat-x scroll 0 0 hsla(0, 0%, 0%, 0);
            border-bottom: 1px solid hsl(0, 0%, 85%);
            font-family: Oswald, Sans-serif;
            font-size: 16px;
            padding: 10px;
            text-transform: uppercase;
            border-top: none;
            border-left: none;
            border-right: none;
            font-weight: normal;
        }

        .ui-widget.infoBoxContainer {
            border: 1px solid #D8D8D8;
        }

        .mj-shoppingcart .ui-widget-content.infoBoxContents, .mj-specialsidebox .ui-widget-content.infoBoxContents, .mj-reviewsidebox.ui-widget-content.infoBoxContents, .mj-currenciessidebox .ui-widget-content.infoBoxContents, .mj-manufacturerinfo .ui-widget-content.infoBoxContents, .mj-productnotification .ui-widget-content.infoBoxContents, .mj-shareproduct .ui-widget-content.infoBoxContents, .mj-order_history .ui-widget-content.infoBoxContents {
            padding: 10px;
        }

        #mj-maincontent .ui-widget-content {
            background: none repeat scroll 0 0 hsla(0, 0%, 0%, 0);
            border: medium none;
            color: inherit;
        }

        .mj-lspace {
            margin-left: 0;
        }

        .navbar .btn-navbar {
            display: none;
            padding: 7px 10px;
            background-color: #2c2c2c;
            background-image: -ms-linear-gradient(top, #333333, #222222);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#333333), to(#222222));
            background-image: -webkit-linear-gradient(top, #333333, #222222);
            background-image: -o-linear-gradient(top, #333333, #222222);
            background-image: linear-gradient(top, #333333, #222222);
            background-image: -moz-linear-gradient(top, #333333, #222222);
            background-repeat: repeat-x;
            border-color: #222222 #222222 #000000;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:dximagetransform.microsoft.gradient(startColorstr='#333333', endColorstr='#222222', GradientType=0);
            filter: progid:dximagetransform.microsoft.gradient(enabled=false);
            -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.075);
            -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.075);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.075);
        }

        input[type="text"]:hover, input[type="password"]:hover, input[type="email"]:hover, input[type="url"]:hover, select:hover {
            background: url(/ext/images/backgrounds.png) repeat-x scroll 0 -40px #E8E8E8;
            color: #000000;
            text-decoration: none;
        }

        input[type="text"], input[type="password"], input[type="email"], input[type="url"], textarea, select {
            border: 1px solid #FFFFFF;
            box-shadow: 0 0 3px #C0C0C0 inset;
            color: #666666;
            line-height: 20px;
            margin: 5px 0 3px;
            min-height: 20px;
            padding: 4px 5px 3px;
            border: 1px solid #D2D2D2;
            background: url(/ext/images/backgrounds.png) repeat-x scroll center top #E8E8E8;
        }

        .button, input[type="submit"], input[type="reset"], input[type="button"], .readmore, button, .link_button {
            border-radius: 3px 3px 3px 3px;
            color: #FFFFFF;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            line-height: 19px;
            margin: 3px 0;
            padding: 5px 4px;
            text-decoration: none;
            text-shadow: 0 1px rgba(0, 0, 0, 0.5);
            width: auto ;
            box-shadow: 0 1px 1px rgba(255, 255, 255, 0.5) inset;
        }

        .button, input[type="submit"], input[type="reset"], input[type="button"], .readmore, button, .link_button {
            background: -moz-linear-gradient(#3692CA, #6CAFD8) repeat scroll 0 0 #3692CA;
            background: -webkit-linear-gradient(#3692CA, #6CAFD8) repeat scroll 0 0 #3692CA;
            background: -ms-linear-gradient(#3692CA, #6CAFD8) repeat scroll 0 0 #3692CA;
            background: -0 -linear-gradient(#3692CA, #6CAFD8) repeat scroll 0 0 #3692CA;
            border: 1px solid #3692CA;
            background-color: #3692CA;
        }

        .button:hover, input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover, .readmore:hover, button:hover, .billto-shipto .details:hover, .profile a:hover, .link_button:hover {
            opacity: 0.9;
        }

        FORM, SELECT, INPUT {
            font-family: 'PT Sans', sans-serif;
            font-size: 14px;
        }

        #search-button {
            background: none repeat scroll 0 0 #E3E5E7 ;
            border-width: 0;
            cursor: pointer;
            font-size: 16px;
            height: 26px;
            padding: 2px 10px;
            text-align: center;
            text-shadow: none;
            top: -5px;
            color: #4B5668;
        }

        #search-button:hover {
            opacity: 1;
        }

        .search input[type="text"] {
            box-shadow: none;
            margin: 0;
            outline: medium none;
            padding: 2px 0 3px 1em;
            width: 90%;
            border: medium none;
        }

        #mj-footer {
            color: #FFFFFF;
            font-size: 14px;
            padding: 46px 0 38px;
            background-image: url(/ext/images/pattern.png);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2) inset;
            background-color: #3692CA;
        }

        #mj-footer, table#cartContentsDisplay tr th, td .mj-boxcontent h2, .searchbtn, #mj-left #categoriesContent li:hover, .tableHeading th, .mj-event-time .mj-month, .mj-block-number .mj-bottom, #accountHistInfo .tableHeading, .jsn-mainnav.navbar .nav > li ul.nav-child lia:hover, .jsn-mainnav.navbar .nav > li ul.nav-child lia:active, #jsn-pos-mainnav li a.current_parent:hover {
            background-color: #3692CA;
        }

        #mj-footer {
            text-align: left;
        }

        #mj-topbar, #mj-header, #mj-navigation, #mj-slideshow, #mj-featured1, #mj-featured2, #mj-featured3, #mj-featured4, #mj-maincontent, #mj-footer, #mj-copyright {
            float: left;
            display: inline;
            width: 100%;
        }

        .mj-dotted h1, .mj-dotted h2, .mj-dotted h3, .mj-dotted h4, .mj-dotted h5, .mj-dotted h6, h1.mj-dotted, h2.mj-dotted, h3.mj-dotted, h4.mj-dotted, h5.mj-dotted, h6.mj-dotted {
            background: url(/ext/images/border.png) repeat-x scroll 0 100% transparent ;
            padding-bottom: 10px;
        }

        #mj-footer h3 {
            font-size: 18px;
            text-transform: uppercase;
            color: #ffffff;
            font-family: Oswald, sans-serif;
            margin-bottom: 10px;
        }

        .moduletable {
            margin-bottom: 10px;
        }

        .mj-grid40 {
            width: 39.666%;
        }

        #mj-copyright {
            background: url(/ext/images/topbar-bg.png) repeat scroll center top #E3E5E7;
            font-size: 12px;
            padding-bottom: 6px;
            padding-top: 6px;
        }

        #mj-copyright .mj-grid88 {
            padding-top: 3px;
        }

        #mj-copyright .top {
            background: url(/ext/images/backtotop.png) no-repeat scroll 0 0 transparent;
            cursor: pointer;
            float: right;
            font-size: 0;
            height: 25px;
            text-indent: -9999px;
            text-transform: capitalize;
            width: 20px;
        }

        #mj-copyright .moduletable, #mj-copyright p {
            margin-bottom: 0;
        }

        #mj-copyright .mj-grid8 {
            float: right;
        }

        #auto-top {
            height: 45px;
        }

        .social_icons_search {
            display: none;
            margin-left: 10px;
        }

        @media only screen and (min-width: 500px) {
            .social_icons_search {
                display: inline-block;
            }
        }

        .breadcrumbs a.pathway, .mj-greybox li:hover a, .mj-greybox li.active a, #mj-left h3 a, #mj-right h3 a, #mj-menu li:hover a, #mj-footer a {
            color: #FFFFFF;
        }

        div.new_cat {
            display: inline-block;
            padding: 5px;
            font-family: Oswald, sans-serif;
            font-size: 14px;
            font-weight: normal;
            text-transform: uppercase;
            margin-top: -7px;
            cursor: pointer;
            width: auto;
        }

        button.new_cat_btn {
            background-color: #151515;
            background-image: none;
            border: none;
            white-space: nowrap;
        }

        ol, ul {
            list-style: none;
        }

        .new_cat:hover {
            opacity: 0.5;
        }

        table td, .centerBoxWrapperContents table td {
            padding: 0px;
        }

        .search table {
            text-align: center;
        }

        .small {
            bottom: 14px;
            font-size: 12px;
            left: 10px;
            position: relative;
        }

        .custom.mj-grid8, .custom.mj-grid16, .custom.mj-grid24, .custom.mj-grid32, .custom.mj-grid40, .custom.mj-grid48, .custom.mj-grid56, .custom.mj-grid64, .custom.mj-grid72, .custom.mj-grid80, .custom.mj-grid88, .custom.mj-grid96 {
            margin-left: 0;
            margin-right: 0;
            width: auto;
        }

        .small_txt {
            bottom: 18px;
            left: 56px;
            position: relative;
        }

        @media screen and (max-width: 700px) {
            .mj-grid8, .mj-grid16, .mj-grid24, .mj-grid32, .mj-grid40, .mj-grid48, .mj-grid56, .mj-grid64, .mj-grid72, .mj-grid80, .mj-grid88, .mj-grid96 {
                float: left;
                margin-left: 0px;
                margin-right: 0px;
                width: 100% ;
                margin-bottom: 10px;
            }
            #auto-top{
                height:87px;
            }
        }

        .fa.fa-mobile.fa-4x {
            font-size: 4em;
            width: 44px;
        }

        @media only screen and (max-width: 450px) and (min-width: 301px) {
            #mj-topbar .mj-grid16 {
                text-align: center;
                width: 100%;
                padding: 0px ;
            }
        }

        amp-sidebar a, amp-accordion a, #new_catalog a {
            border-bottom: 1px solid #ccc;
            padding: 5px 9px 5px 44px;
            position: relative;
            display: block;
            font-size: 18px;
            text-transform: capitalize;
            text-decoration: none;
            font-weight: normal;
            color: #666;
        }

        amp-accordion h4 {
            border-bottom: 1px solid #ccc;
            padding: 5px 9px 5px 44px;
            position: relative;
            display: block;
            font-size: 18px;
            text-transform: capitalize;
            text-decoration: none;
            color: #000;
            font-weight: normal;
            text-transform: uppercase;
            background-color: #E6E6E6;
        }

        #sidebar2 {
            font-family: 'Oswald', sans-serif;
        }

        .search table {
            width: 100%;
        }
    </style>
</head>
<body>
<?php  
require(DIR_WS_CLASSES . 'osc_template.php');
$oscTemplate = new oscTemplate();
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFAULT);
$site_url = (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
?>
<amp-sidebar id="sidebar"
             layout="nodisplay"
             side="left">
    <div id="new_catalog">
        <?php echo GetAMPCategoryMenu(); ?>
    </div>
    </div>
</amp-sidebar>
<amp-sidebar id="sidebar2"
             layout="nodisplay"
             side="left">
    <ul class="nav">
        <li <?php echo $item_menu_01; ?>><a href="<?php echo tep_href_link('index.php') ?>">Магазин</a>
        </li>
        <li><a href="http://forum.yourfish.ru/">Форум</a></li>
        <li><a href="/discount.php">Скидки</a></li>
        <li><a href="/information.php/pages_id/6">Доставка</a></li>
        <li><a href="http://touryour.ru/">Туристическое снаряжение</a></li>
        <li><a href="/map.php">Схема проезда</a></li>
    </ul>
</amp-sidebar>
<div id="mj-container">
    <div id="mj-topbar">
        <div class="mj-subcontainer">
            <div class="nowrap mj-grid16 mj-lspace">
                <span>телефоны клиентской службы</span>
                <br><a href="tel:88002224149">[800] 222-41-49</a>&nbsp;&nbsp;<a href="tel:+74955075547">[495] 507-55-47</a></div>
            <div id="headerShortcuts" class="mj-rspace">
                <ul class="menu">
                    <li><a title="<?= HEADER_TITLE_HOME ?>" href="<?= tep_href_link(FILENAME_DEFAULT, '', 'SSL') ?>">
                            <i class="fa fa-2x fa-home"></i></a></li>
                    <li>
                        <i class="fa  fa-2x menu_bar"></i>
                        <a title="<?= HEADER_TITLE_LOGIN ?>" href="<?= tep_href_link(FILENAME_LOGIN, '', 'SSL') ?>">
                            <i class="fa fa-sign-in fa-2x menu_bar"></i></a></li>
                    <li><i class="fa  fa-2x menu_bar"></i>
                        <a title="<?= HEADER_TITLE_CHECKOUT ?>"
                           href="<?= tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') ?>">
                            <i class="fa fa-2x fa-check-circle menu_bar"></i></a></li>
                    <li><i class="fa  fa-2x menu_bar"></i>
                        <a title="<?= HEADER_TITLE_CART_CONTENTS ?>"
                           href="<? tep_href_link(FILENAME_SHOPPING_CART, '', 'SSL') ?>"><i
                                    class="fa fa-2x fa-shopping-cart menu_bar"><span
                                        id="scartbox_counter"></span></i></a></li>
                </ul>
            </div>
        </div>

    </div>
    <div id="auto-top"></div>
    <div class="breadcrumb_addon">

        <div>
            <div class="search">
                <table>
                    <tr>
                        <td>
                            <div class="new_cat">
                                <button class="new_cat_btn" on="tap:sidebar.toggle"><span>Каталог <i
                                                class="fa fa-angle-right"></i></span>
                                </button>
                            </div>
                        </td>
                        <td>
                            <form target="_top"
                                  name="search" action="<?= tep_href_link('advanced_search_result.php') ?>"  method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <input type="text" name="keywords" class="go" value=" Поиск весь магазин..."
                                            />
                                        </td>
                                        <td>
                                            <button id="search-button" type="submit"><span>поиск</span></button>


                                            <div class="social_icons_search">
                                                <a href="https://vk.com/yourfish_ru"><i class="fa fa-vk fa-2x"></i></a>
                                                <a href="https://www.youtube.com/user/YourFishru"><i
                                                            class="fa fa-youtube fa-2x"></i></a>
                                                <a href="https://twitter.com/YourFish_ru"><i
                                                            class="fa fa-tumblr-square fa-2x"></i></a>
                                            </div>

                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

    </div>
    <div id="mj-righttop">
        <div class="mj-subcontainer">
            <div id="mj-menubar">
                <button id="btn" type="button" class="btn btn-navbar" on="tap:sidebar2.toggle"><span>Главное меню</span>
                </button>
            </div>
        </div>
    </div>


    <div id="mj-maincontent">
        <div class="mj-subcontainer">
            <div id="mj-contentarea" class="mj-grid64 mj-lspace">
                <?php

                $cPath='0';
                if (strlen(trim($cPath)) == 0) {
                    return;
                }
                if (isset($cPath) && strpos('_', $cPath)) {
// check to see if there are deeper categories within the current category
                    $category_links = array_reverse($cPath_array);
                    for ($i = 0, $n = sizeof($category_links); $i < $n; $i++) {
                        $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' ");
                        $categories = tep_db_fetch_array($categories_query);
                        if ($categories['total'] < 1) {
                            // do nothing, go through the loop
                        } else {
                            $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.categories_status=1  order by sort_order, cd.categories_name");
                            break; // we've found the deepest category the customer is in
                        }
                    }
                } else {
                    $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'  and c.categories_status=1  order by sort_order, cd.categories_name");
                }
                $number_of_categories = tep_db_num_rows($categories_query);
                if ($number_of_categories > 0) {
                    echo '<div class="contentText">
<table border="0" width="100%" cellspacing="10" cellpadding="1">
          <tr><td>';
                    $rows = 0;
                if ($cPath !== '0'){
                    ?>
                    <div class="SA_CLB" onclick='SwitchCLB();'><i class="fa fa-sort" aria-hidden="true"></i><span> Показать все <?php echo $catname ?></span>
                    </div>

                <?php
                }
                echo '<div class="CLB">';
                if ($cPath == '0') {
                    echo '<div class="categoryListBoxContents">
	<div class="subproduct_name">
	    <a href="' . tep_href_link(FILENAME_DISCOUNT) . '">' .
                        tep_image($site_url.DIR_WS_IMAGES . 'skidki.png', 'Распродажа склада', 100, 100,'',true) .
                        '<br />Распродажа склада</a>
	    </div>
	    </div>';
                }

                while ($categories = tep_db_fetch_array($categories_query)) {
                    $rows++;
                    $cPath_new = tep_get_path($categories['categories_id']);
                    echo '<div class="categoryListBoxContents"><div class="subproduct_name"><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image($site_url.DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], 100, 100,'',true) . '<br />' . $categories['categories_name'] . '</a></div></div>';
                }
                echo '</div>';
                echo '</td></tr></table></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <div id="mj-footer">
        <div class="mj-subcontainer">
            <div class="moduletable mj-grid40 mj-dotted">
                <h3>Связаться с нами</h3>
                <div class="custom mj-grid40 mj-dotted">
                    <div class="address">
                        <i class="fa fa-home fa-3x"></i>
                        <span class="small">105122, Москва, Щёлковское шоссе д.3 павильон 310</span>
                        <br/>
                        <span class="small_txt"><a href="map.php">Найти нас на карте</a></span>
                    </div>
                    <div class="mail">
                        <i class="fa fa-envelope-o fa-3x"></i>
                        <span class="small">Пишите нам по адресу:</span>
                        <br/>
                        <span class="small_txt"><a href="mailto:magazin@yourfish.ru">magazin@yourfish.ru</a></span>
                    </div>
                    <div class="phone">
                        <i  class="fa fa-mobile fa-4x"></i>
                        <span class="small">24/7 Поддержка по телефону:</span>
                        <br/>
                        <span class="small_txt"> <a href="tel:+7(495)5075547">+7 (495) 507-55-47</a></span>
                    </div>
                    <div class="skype">
                        <i class="fa fa-skype fa-3x"></i>
                        <span class="small">Обращайтесь к нам:</span>
                        <br/>
                        <span class="small_txt"><a href="skype:yourfish.ru">yourfish.ru</a></span>
                    </div>
                    <div class="icq">
                        <i class="fa fa-3x fa-icq"></i>
                        <span class="small">ICQ:</span>
                        <br/>
                        <span class="small_txt">602218037</span>
                    </div>
                    <div class="delivery">
                        <i class="fa fa-3x fa-truck"></i>
                        <span class="small">Доставка</span>
                        <br/>
                        <span class="small_txt"><a href="/information.php?pages_id=6">Условия доставки</a></span>
                    </div>


                    <div class="social_icons">
                        <a href="https://vk.com/yourfish_ru"><i class="fa fa-vk fa-3x"></i></a>
                        <a href="https://www.youtube.com/user/YourFishru"><i class="fa fa-youtube fa-3x"></i></a>
                        <a href="https://twitter.com/YourFish_ru"><i class="fa fa-tumblr-square fa-3x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="mj-copyright">
    <div class="mj-subcontainer">
        <div class="custom mj-grid88" >
            <p class="copyright">&copy;<a href="/">Рыболовный интернет магазин </a>YourFish.ru, 2008-2014.
                <br>
                105122, Москва, Щёлковское шоссе д.3 павильон 310 тел: +7 (495) 507-55-47
                <br>
                В рыболовном интернет магазине доставка почтой рыболовных снастей осуществляется также в следующие
                регионы России: Москва, Санкт-Петербург, Новосибирск, Екатеринбург, Нижний Новгород, Казань, Самара,
                Омск, Челябинск, Ростов-на-Дону, Уфа, Волгоград, Красноярск, Пермь, Воронеж, Саратов, Краснодар,
                Тольятти, Барнаул, Ульяновск, Тюмень, Ижевск, Иркутск, Владивосток, Хабаровск, Улан-Удэ, Подольск,
                Салехард, Тверь, Сочи, Псков, Петрозаводск, Мурманск.
            </p>
        </div>
    </div>
</div>
</body>
</html>



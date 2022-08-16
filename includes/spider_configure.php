<?php
/*
  $Id: spider_configure.php,v 1.2 2003/03/19 22:30:51 Henri Schmidhuber Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
 
 define ('SPIDER_USE_KILLER','true'); // false to deactivate
 
 // Leave as it is !
 $spider_checked_for_spider = 'false'; // DO NOT CHANGE!
 $spider_kill_sid = 'false'; // DO NOT CHANGE!

 // If you want to ban IPs add them like: 
 // $spider_ip[] = "127.0.0.1"; 
 // $spider_ip[] = "127.0.0."; // this banns 127.0.0.xxx
 // $spider_ip[] = "127.0.0"; // this banns 127.0.0xx.xxx
 
 
 // Add more Spiders as you find them (lowercase)
 // i.e. http://www.robotstxt.org/wc/active/html/index.html
 // To test it add your Browser as spider i.e.  
 // $spider_agent[] = "opera";
 // and deactivate cookies
 // don't forget to remove it after testing!
 // 
 // You can also go to:
 // http://www.webconfs.com/search-engine-spider-simulator.php 
 
 // the following are very hard testing they go i.e. for googlebot, annana_bot, baiduspider...
 // If you think it's to hard remove it!
 $spider_agent[] = "spider";
 $spider_agent[] = "bot"; 
 $spider_agent[] = "crawler"; 
 
 // This following list is based on thread at the oscommerce.com forum. (I don't know if it's good)
 // Spiders outcommented are beaten with the keywords above!
 // This enhances the performance a bit ;)
  $spider_agent[] = "abacho"; //Abacho
  $spider_agent[] = "acoon"; //Acoon
  $spider_agent[] = "aesop"; //AESOP
  $spider_agent[] = "alexa"; //Alexa
  // $spider_agent[] = "alkalinebot"; //Vestris
  $spider_agent[] = "all-technology"; //AllTechnology
  $spider_agent[] = "almaden"; //almaden.ibm
  $spider_agent[] = "altavista"; //AltaVista
  $spider_agent[] = "appie"; //Walhello
  $spider_agent[] = "arachnoidea"; //EuroSeek
  // $spider_agent[] = "architextspider"; //Excite
  $spider_agent[] = "architext"; //Excite
  $spider_agent[] = "ariston.netcraft.com"; //Netcraft
  $spider_agent[] = "asterias"; //SingingFish
  $spider_agent[] = "atomz"; //Atomz
  $spider_agent[] = "augurfind";

  $spider_agent[] = "back2roots.org"; //Back2Roots
  // $spider_agent[] = "baiduspider";
  // $spider_agent[] = "bannana_bot";
  $spider_agent[] = "bdcindexer"; 

  $spider_agent[] = "copilot.thunderstone.com"; //Thunderstone 
  $spider_agent[] = "crawl-support@av.com"; //altavista.com 
  // $spider_agent[] = "crawler";
  // $spider_agent[] = "crawler918.com"; //Crawler918
  // $spider_agent[] = "crawler@us.ibm.com"; //IBM.com 


  // $spider_agent[] = "diibot"; //PowerInter
  $spider_agent[] = "dirt.netscape.com"; //ODP
  $spider_agent[] = "docomo";

  $spider_agent[] = "ezresult"; //EZResult

  // $spider_agent[] = "fast-webcrawler"; //AllTheWeb
  $spider_agent[] = "fastsearch.net"; //Fastsearch
  $spider_agent[] = "fireball"; //Fireball
  $spider_agent[] = "fluffy"; //SearchHippo
  // $spider_agent[] = "frooglebot"; 

  $spider_agent[] = "gazz"; //PinPoint
  // $spider_agent[] = "geckobot"; //GeckoBot
  // $spider_agent[] = "gencrawler"; //GenDoor
  // $spider_agent[] = "geobot";
  // $spider_agent[] = "googlebot"; //Googlebot
  $spider_agent[] = "griffon"; //navi.ocn.ne.jp
  $spider_agent[] = "gulliver"; //NorthernLight

  // $spider_agent[] = "henrythemiragorobot"; //Mirago
  $spider_agent[] = "hubater"; //Hubat


  $spider_agent[] = "ia_archiver"; 
  $spider_agent[] = "incywincy"; //IncyWincy
  $spider_agent[] = "info@iltrovatore.it"; //Iltrovatore
  $spider_agent[] = "infoseek";
  $spider_agent[] = "inktomi"; //Inktomi
  $spider_agent[] = "internetseer.net"; //Internetseer
  $spider_agent[] = "ip3000"; //IP3000
  $spider_agent[] = "iron33"; //waseda.ac.jp

  $spider_agent[] = "kit_fireball";

  $spider_agent[] = "lachesis"; 
  $spider_agent[] = "laurion.net"; //IPiumBot
  $spider_agent[] = "libwww"; //Client Sides
  $spider_agent[] = "lnspiderguy"; //Lexis-Nexis
  $spider_agent[] = "looksmart"; //Looksmart
  // $spider_agent[] = "lycos_spider"; //Lycos

  $spider_agent[] = "mantraagent"; //Looksmart
  $spider_agent[] = "marvin/infoseek"; //Webseek
  $spider_agent[] = "mercator"; //Mercator
  $spider_agent[] = "moget"; //goo.ne.jp
  // $spider_agent[] = "mp3bot"; //informatch
  $spider_agent[] = "muscatfe"; //WhizBangLabs
  $spider_agent[] = "muscatferret"; //WhizBangLabs

  $spider_agent[] = "nationaldirectory-webspider";
  // $spider_agent[] = "naverrobot"; 
  $spider_agent[] = "naver.co.jp"; //NaBot
  $spider_agent[] = "nazilla"; //WebMostLinked
  $spider_agent[] = "ncsa beta"; 
  $spider_agent[] = "netresearchserver"; 
  $spider_agent[] = "ng/1.0"; 

  $spider_agent[] = "openfind"; //Openfind
  $spider_agent[] = "osis-project";

  $spider_agent[] = "pa-x.dec.com"; //Compaq/HP
  // $spider_agent[] = "pjspider"; //PortalJuice
  // $spider_agent[] = "polybot"; 
  $spider_agent[] = "pompos";
  // $spider_agent[] = "psbot"; //Picsearch

  $spider_agent[] = "qc.sympatico.ca"; //Sympatico

  // $spider_agent[] = "rabot"; //Daum
  $spider_agent[] = "raubfische"; //Raubfische

  $spider_agent[] = "savantnetworks.com"; //Splatsearch
  $spider_agent[] = "scooter"; //AltaVista
  $spider_agent[] = "seventwentyfour"; 
  $spider_agent[] = "sidewinder"; 
  $spider_agent[] = "singingfish"; //SingingFish
  // $spider_agent[] = "sleek spider";
  $spider_agent[] = "slurp"; //Inktomi
  $spider_agent[] = "speedfind"; //Speedfind
  $spider_agent[] = "steeler"; 
  $spider_agent[] = "sv.av.com"; //Altavista 
  $spider_agent[] = "szukacz"; 
  
  $spider_agent[] = "teoma"; 
  $spider_agent[] = "t-h-u-n-d-e-r-s-t-o-n-e";
  $spider_agent[] = "toutatis"; //Hoppa
  // $spider_agent[] = "turnitinbot"; //turnitin.com 
  
  $spider_agent[] = "uk searcher"; //UK Searcher
  $spider_agent[] = "ultraseek"; //Infoseek

  $spider_agent[] = "vagabondo"; 
  // $spider_agent[] = "voilabot"; 

  // $spider_agent[] = "webcrawler";
  $spider_agent[] = "webreaper"; //WebReaper
  $spider_agent[] = "webwombat"; //WebWombat
  $spider_agent[] = "wire"; //Wire
  // $spider_agent[] = "wscbot"; //WorldSearchCenter
  $spider_agent[] = "www.incom.net"; //NetNoseCrawler

  $spider_agent[] = "x-echo"; //X-Echo

  $spider_agent[] = "yandex"; //Yandex
  
  $spider_agent[] = "zyborg"; //WiseNut

?>

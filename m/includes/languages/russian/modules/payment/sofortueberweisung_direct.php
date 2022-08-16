<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 - 2007 Henri Schmidhuber (http://www.in-solution.de)
  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  if (!defined('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_STATUS')) {
    define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_DESCRIPTION', '<div align="center"><a href=' . tep_href_link('ext/modules/payment/sofortueberweisung/install.php', 'install=sofortueberweisung_direct', 'SSL') . '>' . tep_image('ext/modules/payment/sofortueberweisung/autoinstaller.gif', 'Autoinstaller (empfohlen)') . '</a></div><br><img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.sofortueberweisung.de/cms/index.php?vpartner=21" style="text-decoration: underline; font-weight: bold;">Sofortьberweisung Webseite besuchen</a><br><br>Kontonummer Test Info:<br><br>BLZ#: 88888888');
  } else {
    define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_DESCRIPTION', '<img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.sofortueberweisung.de/cms/index.php?vpartner=21" style="text-decoration: underline; font-weight: bold;">Sofortьberweisung Webseite besuchen</a><br><br>Kontonummer Test Info:<br><br>BLZ#: 88888888');
  }

  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_TITLE', 'Sofortьberweisung Direkt');
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_PUBLIC_TITLE', 'Sofortьberweisung');

  // checkout_payment Informationen via Bild
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_DESCRIPTION_CHECKOUT_PAYMENT', '
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><a href="#" onclick="window.open(\'https://www.sofortueberweisung.de/cms/index.php?vpartner=21\', \'Popup\',\'toolbar=yes,status=no,menubar=no,scrollbars=yes,width=690,height=500\'); return false;">' . tep_image('ext/modules/payment/sofortueberweisung/images/sofortueberweisung.gif', 'Sofortьberweisung ist der kostenlose, TЬV-zertifizierte Zahlungsdienst der Payment Network AG. Ihre Vorteile: keine zusдtzliche Registrierung, automatische Abbuchung von Ihrem Online-Bankkonto, hцchste Sicherheitsstandards und sofortiger Versand von Lagerware. Fьr die Bezahlung mit Sofortьberweisung benцtigen Sie Ihre eBanking Zugangsdaten, d.h. Bankverbindung, Kontonummer, PIN und TAN.') . '</a></td>
      </tr>
    </table>');

  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_DESCRIPTION_CHECKOUT_CONFIRMATION', '
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="main"><p>Nach Bestдtigung der Bestellung werden Sie zum Zahlungssytem von Sofortьberweisung weitergeleitet und kцnnen dort eine Online-Ьberweisung duchfьhren.</p><p>Hierfьr benцtigen Sie Ihre eBanking Zugangsdaten, d.h. Bankverbindung, Kontonummer, PIN und TAN. Mehr Informationen finden Sie hier: <a href="#" onclick="window.open(\'https://www.sofortueberweisung.de/cms/index.php?vpartner=21\', \'Popup\',\'toolbar=yes,status=no,menubar=no,scrollbars=yes,width=690,height=500\'); return false;">http://www.sofortueberweisung.de</a>.</p></td>
      </tr>
    </table>');

 // im Verwendungszweck werden folgende Platzhalter ersetzt:
 // {{order_date}} durch Bestelldatum
 // {{customer_id}} durch Kundennummer der Datenbank
 // {{customer_name}}  durch Kundenname
 // {{customer_company}} durch Kundenfirma
 // {{customer_email}} durch Email des Kunden

  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_V_ZWECK_1', STORE_NAME);  // max 27 Zeichen
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_V_ZWECK_2', 'Nr. {{orderid}} Kd-Nr. {{customer_id}}'); // max 27 Zeichen
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_EMAIL_FOOTER', '');
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_REDIRECT', 'Sie werden nun zu Sofortueberweisung.de weitergeleitet. Sollte dies nicht geschehen bitte den Button drьcken');

  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_ERROR_HEADING', 'Folgender Fehler wurde von Sofortьberweisung wдhrend des Prozesses gemeldet:');
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_ERROR_MESSAGE', 'Zahlung via Sofortьberweisung ist leider nicht mцglich, oder wurde auf Kundenwunsch abgebrochen. Bitte wдhlen sie ein andere Zahlungsweise.');
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_CHECK_ERROR', 'Sofortьberweisungs Transaktionscheck fehlgeschlagen. Bitte manuell ьberprьfen');


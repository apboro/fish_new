<?php
/*
  $Id: breadcrumb.php,v 1.1.1.1 2003/09/18 19:05:14 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class breadcrumb {
    var $_trail;

    function breadcrumb() {
      $this->reset();
    }

    function reset() {
      $this->_trail = array();
    }

    function add($title, $link = '') {
      $this->_trail[] = array('title' => $title, 'link' => $link);
    }

    function trail($separator = ' - ') {
      $trail_string = '<div itemscope itemtype="http://schema.org/BreadcrumbList">';

      for ($i=0, $n=sizeof($this->_trail); $i<$n; $i++) {
        if (isset($this->_trail[$i]['link']) && tep_not_null($this->_trail[$i]['link'])) {
            $trail_string .= '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            $trail_string .= '<a itemprop="item" href="' . $this->_trail[$i]['link'] . '" class="headerNavigation">' .
                '<span itemprop="name">' . urldecode($this->_trail[$i]['title']) . '<span></a>';
            $trail_string .= '<meta itemprop="position" content="'.($i+1).'" /></span>';

        } else {
          $trail_string .= $this->_trail[$i]['title'];
        }

        if (($i+1) < $n) $trail_string .= $separator;
      }

      return $trail_string.'</div>';
    }

    function size() {
	return sizeof($this->_trail);
    }
  


    function trailMobi($separator = ' > ') {
      $trail_string = '';

      for ($i=0, $n=sizeof($this->_trail); $i<$n; $i++) {
        if (isset($this->_trail[$i]['link']) && tep_not_null($this->_trail[$i]['link'])) {
          $trail_string .= '<li><a href="' . $this->_trail[$i]['link'] . '" class="headerNavigation">' . $this->_trail[$i]['title'] . '</a></li>';
        } else {
          $trail_string .= $this->_trail[$i]['title'];
        }

        if (($i+1) < $n) $trail_string .= $separator;
      }

      return $trail_string;
    }
  
}
?>

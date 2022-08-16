<?php
/*
  $Id: boxes.tpl.php,v 1.1.1.1 2003/09/18 19:05:47 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class tableBox {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td align="left" width="'.SIDE_BOX_LEFT_WIDTH.'" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/box_bg_l.gif"><img src="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/box_bg_l.gif" width="'.SIDE_BOX_LEFT_WIDTH.'" height="1"></td>  <td';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td><td width="'.SIDE_BOX_RIGHT_WIDTH.'" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/box_bg_r.gif"><img src="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/box_bg_r.gif" width="'.SIDE_BOX_RIGHT_WIDTH.'" height="1"></td>' . "\n"; 
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }

//////////////////////////////////////////////////////////////////////////////  
// РџСЂРёРјРµСЂ РѕС„РѕСЂРјР»РµРЅРёРµ РґР»СЏ Р±РѕРєСЃР° РєРѕСЂР·РёРЅС‹ - РќР°С‡Р°Р»Рѕ 
/////////////////////////////////////////////////////////////////////////////  
  
  class tableBox_right {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox_right($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td align="left" width="'.SIDE_BOX_LEFT_WIDTH.'" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/box_bg_l_right.gif"><img src="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/box_bg_l_right.gif" width="'.SIDE_BOX_LEFT_WIDTH.'" height="1"></td>  <td';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td><td width="'.SIDE_BOX_RIGHT_WIDTH.'" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/box_bg_r_right.gif"><img src="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/box_bg_r_right.gif" width="'.SIDE_BOX_RIGHT_WIDTH.'" height="1"></td>' . "\n"; 
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
 }
  
//////////////////////////////////////////////////////////////////////////////  
// РџСЂРёРјРµСЂ РѕС„РѕСЂРјР»РµРЅРёРµ РґР»СЏ Р±РѕРєСЃР° РєРѕСЂР·РёРЅС‹ - РљРѕРЅРµС† 
/////////////////////////////////////////////////////////////////////////////  

  class tableBox_clean {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox_clean($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td align="left" width="'.SIDE_BOX_LEFT_WIDTH.'" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/pixel_trans.gif"><img src="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/pixel_trans.gif" width="'.SIDE_BOX_LEFT_WIDTH.'" height="1"></td>  <td';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td><td width="'.SIDE_BOX_RIGHT_WIDTH.'" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/pixel_trans.gif"><img src="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/pixel_trans.gif" width="'.SIDE_BOX_RIGHT_WIDTH.'" height="1"></td>' . "\n"; 
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
 }

class categoriesBox extends tableBox {
function categoriesBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->categoriesBoxContents($contents));
      $this->table_cellpadding = '0';
      $this->table_class = 'noclass';
      $this->tableBox($info_box_contents, true);
    }

function categoriesBoxContents($contents) {
      $this->table_cellpadding = '0';
      $this->table_class = 'noclass';
      $info_box_contents = array();
      for ($i=0; $i<sizeof($contents); $i++) {
        $info_box_contents[] = array(array('align' => 'center', 'params' => 'class="noclass"', 'text' => $contents[$i]['text']));
      }
      return $this->tableBox($info_box_contents);
    }
}

  class infoBox extends tableBox {
    function infoBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));
      $this->table_cellpadding = '0';
      $this->table_parameters = 'class="templateinfoBox"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxContents($contents) {
      $this->table_cellpadding = '2';
      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => (isset($contents[$i]['params']) ? $contents[$i]['params'] : 'class="boxText"'), 
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

  class infoBoxHeading extends tableBox {
    function infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';

      if ($left_corner) {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_left.gif');
      } else {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/no_arrow_right.gif');
      }
      if ($right_corner) {
        $right_corner = $right_arrow . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_right.gif');
      } else {
         $right_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right.gif') .$right_arrow ;

      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => ' class="infoBoxHeading"', 'text' => $left_corner),
                                   array('params' => ' align="center" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/background.gif" width="100%"  class="infoBoxHeading"', 'text' => $contents[0]['text']),
                                   array('params' => ' class="infoBoxHeading"', 'text' => $right_corner));
      $this->tableBox($info_box_contents, true);
    }
  }



  class infoboxFooter extends tableBox {
    function infoboxFooter($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';
      if ($left_corner) {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_flip.gif');
      } else {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_flip.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_flip.gif');
      } else {
        $right_corner = $right_arrow . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_flip.gif');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => ' class="infoBoxHeading"', 'text' => $left_corner),
                                   array('params' => 'background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/backgroundfb.gif" width="100%" ', 'text' => $contents[0]['text']),
 						array('params' => ' class="infoBoxHeading"', 'text' => $right_corner));

      $this->tableBox($info_box_contents, true);
    }
  }

//////////////////////////////////////////////////////////////////////////////  
// РџСЂРёРјРµСЂ РѕС„РѕСЂРјР»РµРЅРёРµ РґР»СЏ Р±РѕРєСЃР° РєРѕСЂР·РёРЅС‹ - РќР°С‡Р°Р»Рѕ 
/////////////////////////////////////////////////////////////////////////////  

  class infoBox_right extends tableBox_right {
    function infoBox_right($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContents_right($contents));
      $this->table_cellpadding = '0';
      $this->table_parameters = 'class="templateinfoBox_right"';
      $this->tableBox_right($info_box_contents, true);
    }

    function infoBoxContents_right($contents) {
      $this->table_cellpadding = '2';
      $this->table_parameters = 'class="infoBoxContents_right"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => (isset($contents[$i]['params']) ? $contents[$i]['params'] : 'class="boxText_right"'), 
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox_right($info_box_contents);
    }
  }

  class infoBoxHeading_right extends tableBox_right {
    function infoBoxHeading_right($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';

      if ($left_corner) {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_left_right.gif');
      } else {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_right.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/arrow_right_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/no_arrow_right_right.gif');
      }
      if ($right_corner) {
        $right_corner = $right_arrow . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_right_right.gif');
      } else {
         $right_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_right.gif') .$right_arrow ;

      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => ' class="infoBoxHeading_right"', 'text' => $left_corner),
                                   array('params' => ' align="center" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/background_right.gif" width="100%"  class="infoBoxHeading_right"', 'text' => $contents[0]['text']),
                                   array('params' => ' class="infoBoxHeading_right" nowrap', 'text' => $right_corner));
      $this->tableBox_right($info_box_contents, true);
    }
  }



  class infoboxFooter_right extends tableBox_right {
    function infoboxFooter_right($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';
      if ($left_corner) {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_flip_right.gif');
      } else {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_flip_right.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/arrow_right_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_flip_right.gif');
      } else {
        $right_corner = $right_arrow . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_flip_right.gif');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => ' class="infoBoxHeading_right"', 'text' => $left_corner),
                                   array('params' => 'background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/backgroundfb_right.gif" width="100%" ', 'text' => $contents[0]['text']),
 						array('params' => ' class="infoBoxHeading_right" nowrap', 'text' => $right_corner));

      $this->tableBox_right($info_box_contents, true);
    }
  }

//////////////////////////////////////////////////////////////////////////////  
// РџСЂРёРјРµСЂ РѕС„РѕСЂРјР»РµРЅРёРµ РґР»СЏ Р±РѕРєСЃР° РєРѕСЂР·РёРЅС‹ - РљРѕРЅРµС† 
/////////////////////////////////////////////////////////////////////////////  

  class contentBox extends tableBox {
    function contentBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContents($contents));
      $this->table_cellpadding = '0';
      $this->table_parameters = 'class="templateinfoBox"';
      $this->tableBox($info_box_contents, true);
    }

    function contentBoxContents($contents) {
      $this->table_cellpadding = '2';
      $this->table_parameters = 'class="infoBoxContents"';
      return $this->tableBox($contents);
    }
  }

  class contentBoxHeading extends tableBox {
    function contentBoxHeading($contents) {
      $this->table_width = '100%';
      $this->table_cellpadding = '0';

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="14" class="infoBoxHeading"',
                                         'text' => tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left.gif')),
                                   array('params' => ' align="center" background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/background.gif" width="100%"  class="infoBoxHeading"',
				         'text' => $contents[0]['text']),
                                   array('params' => 'height="14" class="infoBoxHeading"',
                                         'text' => tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_left.gif')));

      $this->tableBox($info_box_contents, true);
    }
  }

  class contentBoxFooter extends tableBox {
    function contentBoxFooter($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';
      if ($left_corner) {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_flip.gif');
      } else {
        $left_corner = tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_left_flip.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_flip.gif');
      } else {
        $right_corner = $right_arrow . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/corner_right_flip.gif');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' =>  'class="infoBoxfooter"','text' => $left_corner),
                                   array('params' => 'background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/backgroundfb.gif" width="100%" ', 'text' => $contents[0]['text']),
 						array('params' => ' nowrap', 'text' => $right_corner));

      $this->tableBox($info_box_contents, true);
    }
  }

  class errorBox extends tableBox_clean {
    function errorBox($contents) {
      $this->table_data_parameters = 'class="errorBox"';
      $this->tableBox_clean($contents, true);
    }
  }

  class productListingBox extends tableBox {
    function productListingBox($contents) {
      $this->table_parameters = 'class="productListing"';
      $this->tableBox($contents, true);
    }
  }

// Start Products Specifications
  class borderlessBox extends tableBox {
    function borderlessBox ($contents) {
      $this->table_parameters = 'class="main"';
      $this->tableBox ($contents, true);
    }
  }
// End Products Specifications

?>

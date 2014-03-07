<?php

class Zend_View_Helper_MenuItem extends Zend_View_Helper_Abstract {
  public function menuItem($page) {
    if (!$this->view->navigation()->accept($page)) {
      return '';
    }
    if ($page->hasPages()) {
      $output = '<li class="dropdown';
      if ($page->getActive() || $page->findOneBy('active', true)) {
        $output .= ' active';
      }
      $output .= '"><a href="' . $page->getHref() .
        '" class="dropdown-toggle">' . $this->view->translate($page->label) .
        ' <span class="caret"></span></a><ul class="dropdown-menu">';
      foreach ($page->pages as $sub) {
        $output .= $this->menuItem($sub);
      }
      $output .= '</ul></li>';
    } else {
      $output = '<li';
      if ($page->getActive()) {
        $output .= ' class="active"';
      }
      $output .= '><a href="' . $page->getHref() . '">' .
      $this->view->translate($page->label) . '</a></li>';
    }
    return $output;
  }
}

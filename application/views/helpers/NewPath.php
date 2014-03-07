<?php

class Zend_View_Helper_NewPath extends Zend_View_Helper_Abstract {
  public function newPath() {
    return $this->view->url(array(
      'action' => 'new'
    ));
  }
}

<?php

class Zend_View_Helper_EditPath extends Zend_View_Helper_Abstract {
  public function editPath($id) {
    return $this->view->url(array(
      'action' => 'edit',
      'id' => $id
    ));
  }
}

<?php

class Zend_View_Helper_DestroyPath extends Zend_View_Helper_Abstract {
  public function destroyPath($id) {
    return $this->view->url(array(
      'action' => 'destroy',
      'id' => $id
    ));
  }
}

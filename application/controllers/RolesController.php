<?php

class RolesController extends Zf1_Controller_Resource {
  protected function _getForm() {
    if (null === $this->_form) {
      $this->_form = new Application_Form_Role();
    }
    return $this->_form;
  }
}

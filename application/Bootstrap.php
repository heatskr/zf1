<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
  protected function _initErrorHandler() {
    $this->bootstrap('log')->getResource('log')->registerErrorHandler();
  }
}

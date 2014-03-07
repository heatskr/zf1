<?php

class ErrorController extends Zend_Controller_Action {
  public function errorAction() {
    $errorHandler = $this->_getParam('error_handler');
    $exception = $errorHandler->exception;
    $this->view->exception = $exception;
    $this->getInvokeArg('bootstrap')->getResource('log')->log(
      $exception, Zend_Log::ERR);
  }
}

<?php

class Application_View_Filter_Sha1 implements Zend_Filter_Interface {
  public function filter($value) {
    return sha1($value);
  }
}

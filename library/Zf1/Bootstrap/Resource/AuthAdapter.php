<?php

class Zf1_Bootstrap_Resource_AuthAdapter extends Zend_Application_Resource_ResourceAbstract {
  protected $_authAdapter;

  public function init() {
    return $this->getAuthAdapter();
  }

  public function getAuthAdapter() {
    if (null === $this->_authAdapter) {
      $options = $this->getOptions();
      $authAdapter = new Zend_Auth_Adapter_DbTable(
        $this->getBootstrap()->bootstrap('db')->getResource('db'),
        $options['tableName'],
        $options['identityColumn'],
        $options['credentialColumn'],
        $options['credentialTreatment']
      );
      $this->_authAdapter = $authAdapter;
    }
    return $this->_authAdapter;
  }
}

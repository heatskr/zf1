<?php

require_once 'Zend/Application.php';

class Zf1_Application extends Zend_Application {
  public function __construct($environment, $options = null) {
    $tmp = APPLICATION_PATH . '/../data/tmp/' . md5(
      $_SERVER['SERVER_NAME'] . '-' . $environment
    ) . '.tmp';
    if (file_exists($tmp)) {
      parent::__construct($environment, unserialize(file_get_contents($tmp)));
      $this->bootstrap()->run();
    } else {
      parent::__construct($environment, $options);

      // Load profiles
      $_options = array();
      foreach ((array) $this->getOption('profiles') as $profile) {
        $filename = APPLICATION_PATH . '/configs/profiles/' .
          $profile . '.yaml';
        $options = $this->_loadConfig($filename);
        $_options = $this->mergeOptions($_options, $options);
      }
      $options = $this->mergeOptions($this->getOptions(), $_options);
      $this->setOptions($options);

      // Load extensions
      $_options = array();
      foreach ((array) $this->getOption('extensions') as $ext) {
        $filename = APPLICATION_PATH . '/configs/extensions/' .
          $ext . '.yaml';
        $options = $this->_loadConfig($filename);
        $_options = $this->mergeOptions($_options, $options);
      }
      $options = $this->mergeOptions($this->getOptions(), $_options);
      $this->setOptions($options);

      unset($options['config']);
      $this->bootstrap()->run();
      file_put_contents($tmp, serialize($options));
    }

  }
}

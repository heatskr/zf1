<?php

require_once dirname(__FILE__) . '/../library/Zf1/Application.php';

// Define path to application name
defined('APPLICATION_NAME') || define('APPLICATION_NAME',
  (getenv('APPLICATION_NAME') ? getenv('APPLICATION_NAME') :
    $_SERVER['SERVER_NAME']));

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH',
  realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV',
  (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Create application, bootstrap, and run
new Zf1_Application(APPLICATION_ENV,
  APPLICATION_PATH . '/configs/application.yaml');

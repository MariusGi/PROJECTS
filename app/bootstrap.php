<?php

require_once 'config/config.php';

// Load Helpers
require_once 'helpers/UrlHelper.php';
require_once 'helpers/SessionHelper.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'libraries/'.$className.'.php';
});

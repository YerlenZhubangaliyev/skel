<?php
defined('APPLICATION') or define('APPLICATION', getenv('APPLICATION'));
defined('DEVELOPER') or define('DEVELOPER', getenv('DEVELOPER'));
defined('ENVIRONMENT') or define('ENVIRONMENT', getenv('ENVIRONMENT'));
defined('ROOT_DIR') or define('ROOT_DIR', __DIR__ . '/..');

$loader = require_once(ROOT_DIR . '/vendor/autoload.php');

if (0 === strcasecmp(App::ENV_DEVELOPMENT, ENVIRONMENT)) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('opcache.enable', 0);
}

try {
    (new App($loader));
} catch (\Exception $e) {
    var_dump($e->getMessage());die;
}

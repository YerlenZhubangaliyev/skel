<?php
defined('APPLICATION') or define('APPLICATION', getenv('APPLICATION'));
defined('ENVIRONMENT') or define('ENVIRONMENT', getenv('ENVIRONMENT'));
defined('ROOT_DIR') or define('ROOT_DIR', __DIR__ . '/..');

$loader = require_once(ROOT_DIR . '/vendor/autoload.php');

try {
    (new App($loader));
} catch (\Exception $e) {

}

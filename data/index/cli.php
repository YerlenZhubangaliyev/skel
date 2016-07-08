#!/usr/bin/env php
<?php
defined('APPLICATION') or define('APPLICATION', 'Cli');
defined('ENVIRONMENT') or define('ENVIRONMENT', 'Development');
defined('ROOT_DIR') or define('ROOT_DIR', __DIR__ . '/..');

$loader = require_once(ROOT_DIR . '/vendor/autoload.php');

(new App($loader));

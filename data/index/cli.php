#!/usr/bin/env php
<?php
defined('ROOT_DIR') or define('ROOT_DIR', __DIR__ . '/..');

$loader = require_once(ROOT_DIR . '/vendor/autoload.php');

defined('APPLICATION') or define('APPLICATION', 'Cli');
defined('ENVIRONMENT') or define('ENVIRONMENT', (getenv('ENVIRONMENT')) ? getenv('ENVIRONMENT') : App::ENV_LOCAL);

(new App($loader));

<?php

if (true !== defined('APP_PATH')) {
    define('APP_PATH', dirname(dirname(__FILE__)));
}

putenv('APP_ENV=testing');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
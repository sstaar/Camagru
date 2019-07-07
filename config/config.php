<?php

define('S_ROOT', dirname(__DIR__));
define('S_CONFIG', S_ROOT . '/config');
define('S_AUTH', S_ROOT . '/Auth');
define('S_CLASS', S_ROOT . '/Classes');
define('S_CAM', S_ROOT . '/Camera');
define('S_GAL', S_ROOT . '/Gallery');
define('S_PROF', S_ROOT . '/Profile');

define('C_ROOT', '');
define('C_AUTH', C_ROOT . '/Auth');
define('C_CAM', C_ROOT . '/Camera');
define('C_GAL', C_ROOT . '/Gallery');
define('C_PROF', C_ROOT . '/Profile');

define('POSTS_PAGE', 6);

ini_set("display_errors", 1);
ini_set('error_reporting', E_ALL);
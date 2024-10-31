<?php

ini_set( 'display_errors', 1 );

session_start();

define("DSN", "mysql:host=localhost;dbname=otc_control");
define("DB_USER", "otc_control_user");
define("DB_PASSWORD", "ehtpobhkdbnm");

define("TAX_1", 8);
define("TAX_2", 10);

define("IMG_DIR", __DIR__ . '/../img/');
define("HOME_URL", "http://".$_SERVER['HTTP_HOST']. '/oda_pharm/otc_control/');

require_once('functions.php');
require_once('autoload.php');

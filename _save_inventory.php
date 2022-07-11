<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_table_final();
$app->save_csv();

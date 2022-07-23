<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_table_final();

$data = $app->save_csv();

// CSV文字列生成
date_default_timezone_set('Asia/Tokyo');
$filename = date('Ymd_His'). '.csv';
$res = fopen($filename, 'w');
$header = "id,名前,規格,入値,在庫数,小計\r\n";
fwrite($res, $header);
foreach($data as $row){
  $line = implode(',' ,$row);
  mb_convert_encoding($line, 'SJIS-win', 'UTF-8');
  fwrite($res, $line. "\r\n");
}
fclose($res);

//CSV出力
header('Content-Type: application/octet-stream');
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Length: ' . filesize($filename));
readfile($filename);

// header('Location: '. HOME_URL. 'inventory_table_final.php');
exit;
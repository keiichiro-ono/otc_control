<?php

namespace MyApp;

class Inventory_table_final extends Controller{

  public function getAll(){
    $sql = "select *,otc_list.id as mainId from otc_list,otc_class where otc_list.class=otc_class.id and inventory=1 and stock_nums!=0 order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function save_csv(){
    $sql = "select
      otc_list.id as mainId,otc_list.name,otc_list.size,otc_list.purchase_price,otc_list.stock_nums,otc_list.purchase_price*otc_list.stock_nums as subtotal
      from otc_list,otc_class where otc_list.class=otc_class.id and inventory=1 and stock_nums!=0 order by otc_list.kana";
    $stmt = $this->_db->query($sql);
    $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

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

    $destinationfilepath = "csv_data/". $filename;
    if(!rename($filename,$destinationfilepath)){
      echo "ファイルの移動ができません！";
    }else{
      echo "ファイルを移動しました！";
    }

    exit();

  }

}

<?php

namespace MyApp;

class Hygiene_list extends Controller{

  public function allItem(){
    $sql = "select * from otc_list where hygiene=1 order by kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

}

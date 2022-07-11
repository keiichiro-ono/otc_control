<?php

namespace MyApp;

class Warehousing_kiki_list extends Controller{

  public function getAllData(){
    $sql = "select *,warehousing.id as mainId from warehousing,otc_list where
      otc_list.id=warehousing.otc_id and
      (otc_list.class=6 or otc_list.tokutei_kiki='1')
      order by warehousing.date desc";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

  public function ajax_postprocess(){
    $sql = "update warehousing set lot_no=:lot_no where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":lot_no"=>$_POST['lot'],
      ":id"=>$_POST['id']
    ]);
    return $_POST;
  }


}

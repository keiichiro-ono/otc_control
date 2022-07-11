<?php

namespace MyApp;

class Warehousing_list extends Controller{

  public function daylist($ym){
    $sql = "select id,date(created) as date from warehousing
              where date like :date
              group by date order by date desc";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([":date"=>$ym."%"]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getWarehousingOnDate(){
    $sql = "select * from otc_list,warehousing
      where
        otc_list.id=warehousing.otc_id and
        date(warehousing.created)='". $_GET['date']."' order by warehousing.created";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchALL(\PDO::FETCH_OBJ);
  }

  public function getPriceSum(){
    $sql = "select sum(warehousing.enter_nums*warehousing.actual_price) from otc_list,warehousing
      where
        otc_list.id=warehousing.otc_id and
        date(warehousing.created)='". $_GET['date']."'";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();

  }

  public function getWholesaleName($n){
    $sql = "select name from wholesale where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([":id"=>(int)$n]);
    return $stmt->fetchColumn();
  }
}

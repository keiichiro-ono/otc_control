<?php

namespace MyApp;

class Hygiene_list extends Controller{

  public function allItem(){
    $sql = "select *,otc_list.id as mId,otc_list.name as oname,wholesale.name as wname from otc_list,wholesale where 
              hygiene=1 and
              otc_list.wholesale=wholesale.id
              order by kana";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

}

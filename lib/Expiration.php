<?php

namespace MyApp;

class Expiration extends Controller{

  public function monthItems($start, $end, $class){
    $sql = "select
            *,wholesale.name as wholesaleName,otc_list.name as otcName,warehousing.id as mainId
          from
            otc_list,warehousing,wholesale,otc_class
          where
            otc_list.id=warehousing.otc_id and
            otc_list.wholesale=wholesale.id and
            otc_list.class=otc_class.id and
            otc_list.class=$class and
            warehousing.limit_date is not null and
            warehousing.limit_date > '$start 00:00:00' and
            warehousing.limit_date < '$end 00:00:00'
          order by warehousing.limit_date";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getClass(){
    $sql = "select * from otc_class";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

}

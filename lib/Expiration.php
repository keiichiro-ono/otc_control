<?php

namespace MyApp;

class Expiration extends Controller{

  public function allItem(){
    $sql = "select
            *,wholesale.name as wholesaleName,otc_list.name as otcName,warehousing.id as mainId
          from
            otc_list,warehousing,wholesale
          where
            otc_list.id=warehousing.otc_id and
            otc_list.wholesale=wholesale.id and
            warehousing.limit_date is not null
          order by warehousing.limit_date";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

}

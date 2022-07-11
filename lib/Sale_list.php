<?php

namespace MyApp;

class Sale_list extends Controller{

  public function daylist(){
    $sql = "select id,date(created) as date from sales_record group by date order by date desc";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getSaleOnDate(){
    $sql = "select * from otc_list,sales_record
      where
        otc_list.id=sales_record.otc_id and
        date(sales_record.created)='". $_GET['date']."' order by mg_id";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchALL(\PDO::FETCH_OBJ);
  }

  public function getPriceSum(){
    $sql = "select sum(sales_record.sale_nums*sales_record.actual_price) from otc_list,sales_record
      where
        otc_list.id=sales_record.otc_id and
        date(sales_record.created)='". $_GET['date']."'";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchColumn();

  }
}

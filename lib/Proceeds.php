<?php

namespace MyApp;

class Proceeds extends Controller{

  public function search(){
    $word = mb_convert_kana($_POST["word"], "Hc");
    $sql = "select * from otc_list where kana like :kana";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":kana"=> "%". $word. "%"
    ]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function choice(){
    $sql = "select * from otc_list where id=". (int)$_POST['id']. " limit 1";
    $stmt = $this->_db->query($sql);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public function dbInsert(){
    $this->_db->beginTransaction();
    $sql = "insert into saledata (date, otc_id, actual_price, nums, created, modified) values (:date, :otc_id, :actual_price, :nums, now(), now())";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":date"=> $_POST['ymd'],
      ":otc_id"=> (int)$_POST['id'],
      ":actual_price"=> $_POST['actual_price'],
      ":nums"=> (int)$_POST['nums']
    ]);

    $sql = "select * from otc_list where id=". (int)$_POST['id']. " limit 1";
    $stmt = $this->_db->query($sql);
    $d = $stmt->fetch(\PDO::FETCH_OBJ);
    $newStockNums = (int)$d->stock_nums - (int)$_POST['nums'];
    $sql = "update otc_list set stock_nums=".$newStockNums. " where id=". (int)$_POST['id'];
    $stmt = $this->_db->query($sql);
    $this->_db->commit();
    return ['name'=>$d->name, 'stock_nums'=>$newStockNums];
  }


  public function threeDay(){
    $today = date("Y-m-d");
    $threeDayAgo = date("Y-m-d",strtotime("-3 day"));
    $sql = "select *,saledata.id as mainId from saledata,otc_list where
      otc_list.id=saledata.otc_id and
      saledata.date between '".$threeDayAgo."' and '".$today. "' order by saledata.date desc, otc_list.kana";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

  public function deleteSubRow(){
    $this->_db->beginTransaction();
    $sql = "delete from saledata where id=:id limit 1";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([":id"=>(int)$_POST['id']]);

    $sql = "update otc_list set stock_nums=stock_nums+:nums where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":nums"=>(int)$_POST['nums'],
      ":id"=>(int)$_POST['otc_id']
    ]);

    $this->_db->commit();
    return true;
  }


}

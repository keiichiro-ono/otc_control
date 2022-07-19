<?php

namespace MyApp;

class Warehousing extends Controller{

  public function search(){
    $sql = "select * from otc_list where jan=". $_POST['jan'];
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    // var_dump($res);exit;
    return !$res ? false : $res;
  }

  public function inputDb(){
    $this->_db->beginTransaction();
    try{
      $sql = "insert into warehousing (
        date, otc_id, enter_nums, actual_price, limit_date, created, modified
      ) values (
        :date, :otc_id, :enter_nums, :actual_price, :limit_date, now(), now()
      )";
      $stmt = $this->_db->prepare($sql);
      $limit = $_POST['limit']=='' ? null : $_POST['limit'];

      $stmt->execute([
        ":date"=>$_POST['ymd'],
        ":otc_id"=>(int)$_POST['id'],
        ":actual_price"=>$_POST['price'],
        ":enter_nums"=>(int)$_POST['nums'],
        ":limit_date"=>$limit
      ]);

      $sql = "update otc_list set stock_nums=stock_nums+:num where id=:id";
      $stmt = $this->_db->prepare($sql);
      $stmt->execute([
        ":num"=>(int)$_POST['nums'],
        ":id"=>(int)$_POST['id']
      ]);

      $sql = "select name,stock_nums,purchase_price from otc_list where id=".(int)$_POST['id']. " limit 1";
      $stmt = $this->_db->query($sql);
      $res = $stmt->fetch(\PDO::FETCH_ASSOC);

      $this->_db->commit();
      return $res;

    }catch(\PDOException $e){
      $this->_db->rollback();
      echo $e->getMessage();
    }

  }

  public function threeDay(){
    $today = date("Y-m-d");
    $threeDayAgo = date("Y-m-d",strtotime("-3 day"));
    $sql = "select *,warehousing.id as mainId from warehousing,otc_list where
      otc_list.id=warehousing.otc_id and
      warehousing.date between '".$threeDayAgo."' and '".$today. "' order by warehousing.date desc, otc_list.kana";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

  public function deleteSubRow(){
    $this->_db->beginTransaction();
    $sql = "delete from warehousing where id=:id limit 1";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([":id"=>(int)$_POST['id']]);

    $sql = "update otc_list set stock_nums=stock_nums-:nums where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ":nums"=>(int)$_POST['nums'],
      ":id"=>(int)$_POST['otc_id']
    ]);

    $this->_db->commit();
    return true;
  }
  
  public function editSubPrice(){
    try{
      $this->_db->beginTransaction();
      $sql = "update warehousing set actual_price=:price where id=:id limit 1";
      $stmt = $this->_db->prepare($sql);
      $stmt->execute([
        ":price"=>(int)$_POST['new_price'],
        ":id"=>(int)$_POST['id']
      ]);

      $sql = "update otc_list set purchase_price=:price where id=:id";
      $stmt = $this->_db->prepare($sql);
      $stmt->execute([
        ":price"=>(int)$_POST['new_price'],
        ":id"=>(int)$_POST['otc_id']
      ]);

      $this->_db->commit();
    } catch (Exception $e) {
      $this->_db->rollBack();
      echo "失敗しました。" . $e->getMessage();
      exit;
    }
    return true;
  }

  public function _serch_last_day(){
    $month = $_POST['year']. '-'. $_POST['year'];
    $last_date = date('d', strtotime('last day of ' . $month)); 
    var_dump($last_date);exit;
    return $last_date;
  }
}

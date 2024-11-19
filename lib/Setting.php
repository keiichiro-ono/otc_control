<?php

namespace MyApp;

class Setting extends Controller{

  public function inventory_reset(){
    $sql = "update otc_list set inventory=0";
    $this->_db->query($sql);

    // var_dump($this->_db->errorInfo());
    // exit;
  }

  public function get_wholesales(){
    $sql = "select * from wholesale";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

  public function get_classes(){
    $sql = "select * from otc_class";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    return $res;
  }

  public function delete_wholesale_check(){
    $sql = "select count(*) from otc_list where wholesale=:wholesale";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':wholesale'=>(int)$_POST['id']]);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function delete_wholesale(){
    $sql = "delete from wholesale where id=:id limit 1";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':id'=>(int)$_POST['id']]);
  }

  public function create_wholesale(){
    $sql = "insert into wholesale (name) values (:name)";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':name'=>$_POST['name']]);

    $id = $this->_db->lastInsertId();
    return $id;
  }

  public function update_wholesale(){
    $sql = "update wholesale set name=:name where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ':name'=>$_POST['name'],
      ':id'=>(int)$_POST['id']
    ]);
  }

  // otc_classのCRUD
  public function delete_otc_class_check(){
    $sql = "select count(*) from otc_list where class=:otc_class";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':otc_class'=>(int)$_POST['id']]);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function delete_otc_class(){
    $sql = "delete from otc_class where id=:id limit 1";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':id'=>(int)$_POST['id']]);
  }

  public function create_otc_class(){
    $sql = "insert into otc_class (class_name) values (:class_name)";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':class_name'=>$_POST['name']]);

    $id = $this->_db->lastInsertId();
    return $id;
  }

  public function update_otc_class(){
    $sql = "update otc_class set class_name=:name where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
      ':name'=>$_POST['name'],
      ':id'=>(int)$_POST['id']
    ]);
  }


  public function check_nums_all(){
    // $sql = "select * from inventory";
    $sql = "select distinct otc_id from inventory order by otc_id";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // $res = $stmt->fetchColumn();
    return $res;
  }

  public function check_log_inventory($id){

  }

  public function get_inventory_nums_date($id){
    $sql = "select nums,date from inventory where otc_id=$id and date = '2022-08-02'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    return $res;
  }

  public function get_log_nums_date($id){
    $sql = "select new_nums as nums,date_format(created, '%Y-%m-%d') as date from nums_change_log where otc_id=$id and created > '2022-08-02' order by created desc limit 1";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    return $res;
    
  }

  public function check_id_to_in_nums($id, $date){
    $sql = "select sum(enter_nums) from warehousing where otc_id=$id and date > '$date 00:00:00'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function check_id_to_out_nums($id, $date){
    $sql = "select sum(nums) from saledata where otc_id=$id and date > '$date 00:00:00'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function check_id_to_return_nums($id, $date){
    $sql = "select sum(nums) from returneddata where otc_id=$id and date > '$date 00:00:00'";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  // public function check_id_to_change_nums($id, $date){
  //   $sql = "select sum(new_nums-old_nums) from nums_change_log where otc_id=$id and created > '2022-08-02 00:00:00'";
  //   $stmt = $this->_db->query($sql);
  //   $res = $stmt->fetchColumn();
  //   return $res;
  // }

  public function getNums($id){
    $sql = "select stock_nums from otc_list where id=$id";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetchColumn();
    return $res;
  }

  public function getOtcData($id){
    $sql = "select * from otc_list where id=$id";
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $res;
  }
}

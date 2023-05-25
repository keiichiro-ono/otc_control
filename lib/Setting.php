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




}

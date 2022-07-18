<?php

namespace MyApp;

class Setting extends Controller{

  public function inventory_reset(){
    $sql = "update otc_list set inventory=0";
    $this->_db->query($sql);
  }

}

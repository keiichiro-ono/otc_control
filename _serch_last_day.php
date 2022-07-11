<?php

if($_SERVER['REQUEST_METHOD']==="POST"){
  $lastDay = date('j', mktime(0, 0, 0, $_POST['month']+1, 0, $_POST['year']));
  echo $lastDay;
}

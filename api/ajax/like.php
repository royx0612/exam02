<?php

include "../../class/database.class.php";

$db = new Database('goods');
$db->setWhere([
  ['username', '=', $_GET['username']],
  ['AID', '=', $_GET['AID']],
]);
$row = $db->fetch();

if($row){
  $db->delete();
}else{
  $db->create([
    'username' => $_GET['username'],
    'AID' => $_GET['AID'],
  ]);
}


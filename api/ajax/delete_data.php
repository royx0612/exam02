<?php

include "../../class/database.class.php";

$db = new Database($_POST['table']);
unset($_POST['table']);

// 條件
$conditions = [];
foreach($_GET['columns'] as $index => $column){
  $conditions[] = [$column, '=', $_GET['values'][$index]];
}
$db->setWhere($conditions);

$db->delete();

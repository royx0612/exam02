<?php

include "../../class/database.class.php";

$db = new Database($_GET['table']);

// 條件
$conditions = [];
foreach($_GET['columns'] as $index => $column){
  $conditions[] = [$column, '=', $_GET['values'][$index]];
}
$db->setWhere($conditions);

$rows = $db->fetchAll();

print ($rows) ? json_encode($rows) : '';
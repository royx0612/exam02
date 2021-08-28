<?php

include "../../class/database.class.php";

$db = new Database('admins');

$db->setWhere([
  ['username', '=', $_POST['username']],
  ['password', '=', $_POST['password']],
]);

$row = $db->fetch();
if($row) $_SESSION['username'] = $_POST['username'];
print ($row) ? json_encode($row) : '';
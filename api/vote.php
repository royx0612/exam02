<?php

include "../class/database.class.php";

$db = new Database('questionnaire_options');

$db->setWhere([
  ['id', '=', $_POST['id']]
]);
$row = $db->fetch();
$db->update([
  'voted' => $row['voted'] +1
]);

header("Location: /index.php?do=questionnaire");
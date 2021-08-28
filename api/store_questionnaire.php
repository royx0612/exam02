<?php

include "../class/database.class.php";

$dbQuestionnaire = new Database('questionnaires');
$insertID = $dbQuestionnaire->create([
  'subject' => $_POST['subject']
]);

$dbQuestionnairOption = new Database('questionnaire_options');
foreach ($_POST['options'] as $option) {
  $dbQuestionnairOption->create([
    'QID' => $insertID,
    'text' => $option,
    'voted' => 0
  ]);
}

header("Location:".$_SERVER['HTTP_REFERER']);
<?php
$dbQuestionnaire = new database('questionnaires');
$dbQuestionnaire->setWhere([
  ['id', '=', $_GET['QID']]
]);
$rowQuestionnaire = $dbQuestionnaire->fetch();

$dbOption = new Database('questionnaire_options');
$dbOption->setWhere([
  ['QID', '=', $_GET['QID']]
]);
$rowsOption = $dbOption->fetchAll();
?>
<form action="/api/vote.php" method="post">
  <fieldset>
    <legend>目前位置: 首頁 > 問卷調查 > <?= $rowQuestionnaire['subject'] ?></legend>
    <p><b><?= $rowQuestionnaire['subject'] ?></b></p>
    <?php foreach ($rowsOption as $option) : ?>
      <p>
        <input type="radio" name="id" value="<?= $option['id'] ?>">
        <?= $option['text'] ?>
      </p>
    <?php endforeach ?>
    <div><input type="submit" value="我要投票"></div>
  </fieldset>
</form>
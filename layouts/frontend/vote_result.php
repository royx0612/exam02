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

// 計算總票數
$columnVoted = array_column($rowsOption, 'voted');
$totalVoted = array_reduce($columnVoted, function ($sum, $item) {
  return $sum += $item;
});
?>
<form action="/api/vote.php" method="post">
  <fieldset>
    <legend>目前位置: 首頁 > 問卷調查 > <?= $rowQuestionnaire['subject'] ?></legend>
    <p><b><?= $rowQuestionnaire['subject'] ?></b></p>
    <table>
      <?php foreach ($rowsOption as $index => $option) : ?>
        <tr>
          <td>
            <?= sprintf("%s. %s", ($index + 1), $option['text']) ?>
          </td>
          <td>
            <?= sprintf(
              "<span style='background-color:gray;height:20px;width:%spx;display:inline-block'></span>%s票(%s%%)",
              round($option['voted'] / $totalVoted * 100),
              $option['voted'],
              round($option['voted'] / $totalVoted * 100)
            ) ?>
          </td>
        </tr>
      <?php endforeach ?>
    </table>
  </fieldset>
</form>
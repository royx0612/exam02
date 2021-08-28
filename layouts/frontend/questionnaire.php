<?php
$db = new Database('questionnaires');
$sql = sprintf("SELECT a.*, sum(b.voted) as voted from `questionnaires` as a left join `questionnaire_options` as b ON a.id = b.QID group by a.id");
$rows = $db->customQuery($sql);

?><fieldset style="width:fit-content">
  <legend>目前位置:首頁 > 問卷調查</legend>
  <table>
    <thead>
      <tr>
        <td>編號</td>
        <td>問卷題目</td>
        <td>頭票總數</td>
        <td>結果</td>
        <td>狀態</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) : ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['subject'] ?></td>
          <td><?= $row['voted'] ?></td>
          <td><a href="index.php?do=vote_result&QID=<?=$row['id']?>">結果</a></td>
          <td>
            <?php if (!isset($_SESSION['username'])) : ?>
              <a href="index.php?do=login">請先登入</a>
            <?php else : ?>
              <a href="index.php?do=vote&QID=<?=$row['id']?>">參與投票</a>
            <?php endif ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</fieldset>
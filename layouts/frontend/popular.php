<?php
$db = new Database('articles');
$page = $_GET['page'] ?? 1;
$totalPage = ceil($db->math('count', 'id') / 5);

$sql = sprintf("SELECT a.*, count(b.AID) as goods from `articles` as a left join `goods` as b on a.id = b.AID group by a.id order by goods DESC limit %s, %s", ($page - 1) * 5, 5);
$rows = $db->customQuery($sql);



// 取得使用者的按讚文章
if (isset($_SESSION['username'])) {
  $dbUserGood = new Database('goods');
  $dbUserGood->setWhere([
    ['username', '=', $_SESSION['username']]
  ]);
  $rowsUserGoods = $dbUserGood->fetchAll();
  $userGoods = array_column($rowsUserGoods, 'AID');
}


?>
<fieldset>
  <legend>目前位置:首頁 > 最新文章區</legend>
  <table>
    <thead>
      <tr>
        <td>標題</td>
        <td>內容</td>
        <td>人氣</td>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($rows as $row) {
        printf("<tr>");
        printf("<td width='20%%'>%s</td>", $row['title']);
        printf(
          "
        <td class='content' width='60%%'>
          <div>%s ...</div> 
          <div style='display:none'>%s</div>
        </td>",
          mb_substr($row['content'], 0, 20),
          $row['content']
        );
        printf(
          "<td>%s 個人說<span class='good'></span> - <span class='like' data-AID='%s'>%s</span></td>",
          $row['goods'],
          $row['id'],
          in_array($row['id'], $userGoods) ? '收回讚' : '按讚'
        );
        printf("</tr>");
      }
      ?>
      <tr>
        <td colspan="3" style="text-align: center;">
          <?php
          if ($page - 1 >= 1) {
            printf("<a href='?do=news&page=%s'> %s </a>", ($page - 1), ' ＜ ');
          }

          for ($i = 1; $i <= $totalPage; $i++) {
            printf(
              "<a href='?do=news&page=%s'> %s </a>",
              $i,
              ($page == $i) ? "<span style='font-size:1.5rem'>{$i}</span>" : $i
            );
          }

          if ($page + 1 <= $totalPage) {
            printf("<a href='?do=news&page=%s'> %s </a>", ($page + 1), ' ＞ ');
          }
          ?>
        </td>
      </tr>
    </tbody>
  </table>
</fieldset>

<script>
  $(document).ready(function() {
    $('.content').click(function() {
      $(this).find('div').toggle();
    })

    $('.like').click(function() {
      $.get('/api/ajax/like.php', {
        username: '<?= $_SESSION['username'] ?>',
        AID: $(this).attr('data-AID')
      }, res => {
        location.reload();
      })
    })
  })
</script>
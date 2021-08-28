<?php
$db = new Database('articles');
$page = $_GET['page'] ?? 1;
$totalPage = ceil($db->math('count', 'id') / 3);
$db->setLimit([($page - 1) * 3, 3]);
$rows = $db->fetchAll();


?>

<fieldset style="width:fit-content; margin:auto">
  <legend>文章管理</legend>
  <form action="/api/update.php" method="post">
    <table style="width:100%;text-align:left">
      <thead>
        <tr>
          <td>編號</td>
          <td>標題</td>
          <td>顯示</td>
          <td>刪除</td>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($rows as $row) {
          printf("<tr><input type='hidden' name='id[]' value='%s'>", $row['id']);
          printf("<td>%s</td>", $row['id']);
          printf("<td>%s</td>", $row['title']);
          printf("<td><input type='checkbox' name='visible[]' value='%s' %s></td>", $row['id'], $row['visible'] ? 'checked' : '');
          printf("<td><input type='checkbox' name='delete[]' value='%s'></td>", $row['id']);
          printf("</tr>");
        }
        ?>
        <tr>
          <td colspan="4" style="text-align: center;">
            <?php
            if ($page - 1 > 0) {
              printf("<a href='?do=article&page=%s'> %s </a>", ($page - 1), ' ＜ ');
            }

            for ($i = 1; $i <= $totalPage; $i++) {
              printf(
                "<a href='?do=article&page=%s'> %s </a>",
                $i,
                ($page == $i) ? "<span style='font-size:1.5rem'>{$i}</span>" : $i
              );
            }

            if ($page + 1 < $totalPage) {
              printf("<a href='?do=article&page=%s'> %s </a>", ($page + 1), ' ＞ ');
            }
            ?>
          </td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: center;">
            <input type="hidden" name="table" value="articles">
            <input type="submit" value="確定修改">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
<?php
$db = new Database('articles');
$sql = "SELECT * from `articles` group by category";
$rows = $db->customQuery($sql);

?>

<div>目前位置: 首頁 > 分類網誌 > <span id="subTitle">慢性病防治</span></div>
<fieldset style="width:fit-content">
  <legend>分類網誌</legend>
  <?php foreach ($rows as $row) : ?>
    <div class="category"><?= $row['category'] ?></div>
  <?php endforeach ?>
</fieldset>
<fieldset style="width:fit-content">
  <legend>文章列表</legend>
  <div id="subContent">
  </div>
</fieldset>
<fieldset style="width:fit-content">
  <legend>文章內容</legend>
  <div id="content">
  </div>
</fieldset>
<script>
  $('.category').click(function() {
    $.get('/api/ajax/get_datas.php', {
      table: 'articles',
      'columns[]': 'category',
      'values[]': $(this).text()
    }, rows => {
      if (rows) {
        rows = JSON.parse(rows);
        let html = '';
        for (const row of rows) {
          html += `<div class="articles" data-id="${row.id}">${row.title}</div>`;
        }
        $('#subContent').html(html);
        $('#subTitle').text($(this).text());

        $('.articles').click(function() {
          $.get('/api/ajax/get_datas.php', {
            table: 'articles',
            'columns[]': 'id',
            'values[]': $(this).attr('data-id')
          }, rows => {
            if (rows) {
              row = JSON.parse(rows)[0];
              $('#content').text(row.content);
            }
          });
        });
      }
    });
  });
  $('.category')[0].click();
</script>
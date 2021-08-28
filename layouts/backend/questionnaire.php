<?php


?>
<form action="/api/store_questionnaire.php" method="post">
  <fieldset style="width:fit-content;margin:auto">
    <legend>新增問卷</legend>
    <div>問卷名稱 <input type="text" name="subject"></div>
    <div id="options">
      <div>
        選項 <input type="text" name="options[]">
        <input type="button" value="更多" onclick="NewOption()">
      </div>
    </div>
    <div>
      <input type="submit" value="新增">
      <input type="reset" value="清空">
    </div>
  </fieldset>
</form>

<script>
  function NewOption(){
    let html = `<div>選項 <input type="text" name="options[]</div">`;
    $('#options').append(html);
  }
</script>
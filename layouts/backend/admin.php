<?php
$db = new Database('admins');
$rows = $db->fetchAll();

?>

<fieldset style="width:fit-content; margin:auto">
  <legend>帳號管理</legend>
  <form action="/api/manage.php" method="post">
    <table style="width:100%;text-align:center">
      <thead>
        <tr>
          <td>帳號</td>
          <td>密碼</td>
          <td>刪除</td>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($rows as $row) {
          printf("<tr><input type='hidden' name='id[]' value='%s'>", $row['id']);
          printf("<td>%s</td>", $row['username']);
          printf("<td>****</td>");
          printf("<td><input type='checkbox' name='delete[]' value='%s'></td>", $row['id']);
          printf("</tr>");
        }
        ?>
        <tr>
          <td colspan="3">
            <input type="submit" value="確定刪除">
            <input type="hidden" name="table" value="admins">
            <input type="reset" value="清空選取">
          </td>
        </tr>
      </tbody>
    </table>
  </form>

  <h3>新增會員</h3>
  <div style="color: red;">*請設定您要註冊的帳號及密碼(最常12個字元)</div>
    <table>
      <tr>
        <td>Step1:登入帳號</td>
        <td><input type="text" name="username" id="username"></td>
      </tr>
      <tr>
        <td>Step2:登入密碼</td>
        <td><input type="password" name="password" id="password"></td>
      </tr>
      <tr>
        <td>Step3:再次確認密碼</td>
        <td><input type="password" name="password_confirm"></td>
      </tr>
      <tr>
        <td>Step4:信箱(忘記密碼時使用)</td>
        <td><input type="text" name="email" id="email"></td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="button" value="登入" onclick="Register()">
          <input type="reset" value="清除">
        </td>
      </tr>
    </table>
</fieldset>


<script>
  function Register() {
    let username = $('#username').val(),
      password = $('#password').val(),
      email = $('#email').val();

    if (!username || !password || !email) {
      alert('不可空白');
      return false;
    }

    $.get('/api/ajax/get_datas.php', {
      table: 'admins',
      'columns[]': 'username',
      'values[]': username
    }, res => {
      if (res) {
        alert('帳號重複');
      } else {
        $.post('/api/ajax/register.php', {
          table: 'admins',
          username,
          password,
          email
        }, res => {
          location.reload();
        });
      }
    });
  }
</script>
<fieldset style="width:fit-content;margin:auto">
  <legend>會員登入</legend>
  <table>
    <tr>
      <td>帳號</td>
      <td><input type="text" name="username" id="username"></td>
    </tr>
    <tr>
      <td>密碼</td>
      <td><input type="text" name="password" id="password"></td>
    </tr>
    <tr>
      <td>
        <input type="button" value="登入" onclick="Login()">
        <input type="reset" value="清除">
      </td>
      <td>
        <a href="index.php?do=forgot_password">忘記密碼</a>
        <a href="index.php?do=register">尚未註冊</a>
      </td>
    </tr>
  </table>
</fieldset>

<script>
  function Login() {
    $.get('/api/ajax/get_datas.php', {
      table: 'admins',
      'columns[]': 'username',
      'values[]': $('#username').val(),
    }, res => {
      if (res) {
        $.post('/api/ajax/login.php', {
          username: $('#username').val(),
          password: $('#password').val(),
        }, res => {
          if (res) {
            location.href="backend.php";
          } else {
            alert('密碼錯誤');
          }
        })
      } else {
        alert('查無帳號');
      }
    })
  }
</script>
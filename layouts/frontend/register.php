<form action="/api/register.php" method="post">
  <fieldset style="width:fit-content;margin:auto">
    <legend>會員註冊</legend>
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
</form>

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
          location.href = "index.php?do=login";
        });
      }
    });
  }
</script>
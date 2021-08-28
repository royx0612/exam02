<form action="/api/register.php" method="post">
  <fieldset style="width:fit-content;margin:auto">
    <legend>忘記密碼</legend>
    <div>請輸入信箱以查詢密碼</div>
    <input type="text" id="email">
    <div id="tip"></div>
    <div><input type="button" value="尋找" onclick="ForgotPassword()"></div>
  </fieldset>
</form>

<script>
  function ForgotPassword() {
    let email = $('#email').val();
    $.get('/api/ajax/get_datas.php', {
      table: 'admins', 
      'columns[]': 'email', 
      'values[]': email
    }, res => {
      if(res){
        res = JSON.parse(res);
        $('#tip').text(`您的密碼為: ${res[0].password}`);
      }else{
        $('#tip').html('查無資料');
      }
    })
  }
</script>
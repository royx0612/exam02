<?php
include "../class/database.class.php";

$db = new Database($_POST['table']);
unset($_POST['table']);
foreach ($_POST['id'] as $index => $id) {
  $db->setWhere([
    ['id', '=', $id]
  ]);

  // 刪除
  if (isset($_POST['delete']) && in_array($id, $_POST['delete'])) {
    $db->delete();
  } else {
    $data = [];
    # 資料整理
    array_walk(array_keys($_POST), function ($key) use (&$data, $index) {
      if ($key != 'id' && $key != 'delete') $data[$key] = $_POST[$key][$index];
    });
    
    // 是否有顯示列表
    if (isset($_POST['visible'])) {
      $data['visible'] = in_array($id, $_POST['visible']) ? '1' : '0';
    }

    // 是否有檔案
    if(isset($_FILES['file'])){
      move_uploaded_file($_FILES['file']['tmp_file'], '../images/'.$_FILES['file']['name']);
      $data['file'] = $_FILES['file']['name'];
    }

    // 新增資料
    if ($id == 'NEW') {
      $db->create($data);

    // 修改資料
    } else {
      if ($data) $db->update($data);
    }
  }
}

header("Location:" . $_SERVER['HTTP_REFERER']);

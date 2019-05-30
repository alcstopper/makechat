<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
  // 対象スレッドのidそ取得
  $id = $_REQUEST['id'];

  $messages = $db->prepare('SELECT * FROM threads WHERE id=?');
  $messages->execute(array($id));
  $message = $messages->fetch();

echo $message['thread_name'];
  if ($message['member_id'] == $_SESSION['id']) {
    $del_thre = $db->prepare('DELETE FROM threads WHERE id=?');
    $del_thre->execute(array($id));
  }
  $table = $message['thread_name'];
  $del_table = "DROP TABLE IF EXISTS `{$table}`";
  $db->query($del_table);
}

header('Location: index.php');
exit();
?>

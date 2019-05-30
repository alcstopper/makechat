<?php
  require('dbconnect.php');
$tabel_name = $_POST['thread_name'];
  // テーブル作成のSQLを作成
  // 変数部分はバッククォートで囲む
$res_sql = "CREATE TABLE `{$tabel_name}` (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  talk TEXT(255) NOT NULL,
  member_id INT(11) NOT NULL
) default charset=utf8";
?>

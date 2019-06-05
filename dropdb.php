<?php
require('dbconnect.php');
$table = $message['thread_name'];
$del_table = 'DROP TABLE IF EXISTS' .{$table};

$res_sql = "CREATE TABLE `{$tabel_name}` (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  talk TEXT(255) NOT NULL,
  member_id INT(11) NOT NULL
) default charset=utf8";
?>

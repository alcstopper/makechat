<?php
try {
  $db = new PDO('mysql:dbname=study;host=111.108.8.42;charset=utf8', 'root', 'ashimon');
}  catch(PDOException $e) {
  print('DB接続エラー:' . $e->getMessage());
}
?>

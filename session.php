<?php
// sessionにIDがセットされれいるか調べる
// sessionにIDがあり、sessionされた時間が3600秒(1時間)より小さい場合
if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  // 何か行動を起こした時にセッションタイムを更新する
  $_SESSION['time'] = time();
  // ログインしているユーザーのIDを取得する
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  // SESSIONのIDを使ってデータベースからIDを引っ張る
  $members->execute(array($_SESSION['id']));
  // $membersから$memberに対してfetchをして取得したIDを保存する
  $member = $members->fetch();
} else {
  // ログインしていない場合はログイン画面に遷移する
  header('Location: login.php');
  exit();
}
 ?>

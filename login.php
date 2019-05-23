<?php
// ログイン情報をセッションに保存したい
session_start();
// ログイン情報の正否確認の為にデータベースに接続する
require('dbconnect.php');
// $_POSTの値（この場合はログイン情報）が入っているか判定する
// $_POSTの値が空でなければ実行
if($_POST['email'] !== '' && $_POST['password'] !== ''){
  // データベースに問い合わせ
  // プリペアードステートメントを使ってSQL文を実行
  // SELECT文でデータを指定して取得する
  $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
  // emailとpasswordの?の部分に入力された$_POSTの値を指定してデータベースに問い合わせる
  // 配列を生成して値を指定する
  $login->execute(array(
    $_POST['email'],
    // パスワードはsha1の暗号に変換して、データベースのsha1に変換されたパスワードと同じ形式にして確認する
    sha1($_POST['password'])
  ));
  // $memberの値と$loginの値が一致すればログインに成功している
  $member = $login->fetch();
  // もし$memberに値が入っていればtrue
  // (空はfalse,空でない場合はtrue)
  // ログインに成功している場合はtrueの処理に移る
  if($member){
    // セッション変数に値を入れる
    // 配列のidをセッションidに入れる
    $_SESSION['id'] = $member['id'];
    // セッションタイムに現在の時刻を代入する
    $_SESSION['time'] = time();
    header('Location:index.php');
    exit();
    // ログイン失敗
  } else{
    $error['login'] = 'failed';
  }
  // emailかpasswordの値が空の場合
} else{
  $error['login'] = 'blank'
}
 ?>

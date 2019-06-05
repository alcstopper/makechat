<?php
session_start();
// データベースに問い合わせ
require('dbconnect.php');
require('createdb.php');
require('header.php');
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
// 作成ボタンがクリックされたとき
if(!empty($_POST)) {
	// スレッド名の書込みがあれば
	if($_POST['thread_name'] !== '') {
		// データベースにアクセスして値を挿入する
		$thread_name = $db->prepare('INSERT INTO threads SET thread_name=?, partner_id=?, member_id=?');
		// ?の値に配列で値を入れる
		$thread_name->execute(array(
			$_POST['thread_name'],
			$_GET['id'],
			$member['id'],));
			// スレッド内のテーブル作成
			$db->query($res_sql);
			// 外部キーを設定する
			// $db->query($refer_sql);
			// index.phpを自動的に呼び出し、ポストの値を空にする
			header('Location: index.php');
			exit();
		}
	}
	?>
	<!DOCTYPE html>
	<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>makechat</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<form action="" method="post">
				<h2>スレッド名を入力してください</h2>
				<textarea name="thread_name" rows="2" cols="30"></textarea>
				<input type="submit" value="作成" />
			</form>
		</body>
		</html>

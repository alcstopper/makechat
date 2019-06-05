<?php
session_start();
require('../dbconnect.php');

if(!isset($_SESSION['join'])){
	header('Location: index.php');
	exit();
}
// POSTの値が空でなければ
if (!empty($_POST)) {
	// membersテーブルに会員情報を挿入する
	$statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, created=NOW()');
	// POSTの値を設定する
	$statement->execute(array(
		$_SESSION['join']['name'],
		$_SESSION['join']['email'],
		sha1($_SESSION['join']['password']),
	));
	// データベースに値を挿入したらSESSIONの値を削除して完了画面に遷移
	unset($_SESSION['join']);
	header('Location: complete.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>会員登録</title>
	<link rel="stylesheet" href="style.css" />
	<body>
		<form action="" method="post">
			<input type="hidden" name="action" value="submit" />
			<p>名前</p>
			<!-- SESSIONの値を連想配列で出力する -->
			<p><?php print(htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES));?></p>

			<p>メールアドレス</p>
			<p><?php print(htmlspecialchars($_SESSION['join']['email'],ENT_QUOTES));?></p>

			<p>パスワード</p>
			<p>【非表示】</p>
			<a href="index.php?action=rewrite">書き直す</a> | <input type="submit" value="登録する" />
		</form>

	</body>
	</html>

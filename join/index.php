<?php
session_start();
// データベースに問い合わせ
require('../dbconnect.php');
// $_POSTの値が空でなければ実行する
if(!empty($_POST)){
	// エラーチェック
	// 値が空の場合はエラー
	if($_POST['name'] === ''){
		$error['name'] = 'blank';
	}
	if($_POST['email'] === ''){
		$error['email'] = 'blank';
	}
// パスワードが４文字未満ならエラー
	if(strlen($_POST['password']) < 4){
		$error['password'] = 'length';
	}
	if($_POST['password'] === ''){
		$error['password'] = 'blank';
	}
	// アカウントの重複チェック
	// $errorが空であれば(エラーでなければ)
	if(empty($error)) {
		// メンバーズテーブルからメールの件数(省略名cnt)を取得し、格納する
		$member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
		// 入力したメールアドレスのメンバーが存在するか確認する
		// アドレスが既に存在していれば件数1、なければ件数0を返す
		$member->execute(array($_POST['email']));
		$record = $member->fetch();
		// 件数(省略名cnt)が0より大きければ
		if($record['cnt'] > 0) {
			$error['email'] = 'duplicate';
		}
	}
	// $errorが空であれば
	if(empty($error)) {
		// $_POSTの値をSESSIONに保管する
		$_SESSION['join'] = $_POST;
		// check.phpに移動する
		header('Location: check.php');
		exit();
	}
}
// 確認画面から書き直す処理を選択した際に施す
// URLパラメータにactionのrewriteがあり、$_SESSIONのjoinがあれば$_POSTにjoinの値を入れる
if($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
	$_POST = $_SESSION['join'];
}
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>会員登録画面</title>
	<link rel="stylesheet" href="style.css" />
<body>
	<form action="" method="post">
		<p>名前<input type="text" name="name" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['name'],ENT_QUOTES));?>" /></p>
		<?php if($error['name'] === 'blank'): ?>
			<p class="error">名前を入力してください</p>
		<?php endif; ?>

		<p>メールアドレス<input type="text" name="email" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['email'],ENT_QUOTES));?>" /></p>
		<?php if($error['email'] === 'blank'): ?>
			<p class="error">メールアドレスを入力してください</p>
		<?php endif; ?>
		<?php if($error['email'] === 'duplicate'): ?>
			<p class="error">指定されたメールアドレスは既に登録されています</p>
		<?php endif; ?>

		<p>パスワード<input type="text" name="password" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES));?>" /></p>
		<?php if($error['password'] === 'length'): ?>
			<p class="error">パスワードは4文字以上で入力してください</p>
		<?php endif; ?>
		<?php if($error['password'] === 'blank'): ?>
			<p class="error">パスワードを入力してください</p>
		<?php endif; ?>

		<input type="submit" value="確認"/>
	</form>
</body>
</html>

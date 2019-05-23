<?php
// データベースに問い合わせ
require('dbconnect.php');
require('createdb.php');
// 作成ボタンがクリックされたとき
if(!empty($_POST)) {
	// スレッド名の書込みがあれば
	if($_POST['thread_name'] !== '') {
		// データベースにアクセスして値を挿入する
		$thread_name = $db->prepare('INSERT INTO threads SET thread_name=?');
		// ?の値に配列で値を入れる
		$thread_name->execute(array($_POST['thread_name']));
		// スレッド内のテーブル作成
		$db->query($res_sql);
		// index.phpを自動的に呼び出し、ポストの値を空にする
		header('Location: index.php');
		exit();
	}
}
		// 投稿したスレッド名の一覧とそれに付随するidを取得する
		$threads = $db->query('SELECT thread_name , id FROM threads');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>makechat</title>
	<link rel="stylesheet" href="style.css" />
<body>
	<form action="" method="post">
		<p>スレッド名</p>
		<textarea name="thread_name" rows="2" cols="30"></textarea>
		<input type="submit" value="作成" />
		<!-- resのidを取得してres.phpに送る -->
		<input type="hidden" value="res.php?id" />
	</form>
	<h1>スレッド</h1>
	<!-- メッセージ一覧を表示する -->
	<!-- $threadsの配列の中身を繰り返し精査しながら$thread変数に渡し、最後まで精査が終わったら繰り返しを終える -->
	<?php foreach ($threads as $thread): ?>
		<!-- エスケープ処理をしてhtmlに表示し、ENT_QUOTESでシングルクォーテーションとダブルクォーテーションの区別をなくす -->
	<p><a href=res.php?id=<?php print(htmlspecialchars($thread['id'], ENT_QUOTES)); ?>><?php print(htmlspecialchars($thread['thread_name'], ENT_QUOTES)); ?></a></p>
	<?php endforeach; ?>
</body>
</html>

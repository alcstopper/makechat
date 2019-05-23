<?php
// データベースに問い合わせ
require('dbconnect.php');
// 作成ボタンがクリックされたとき
if(!empty($_POST)) {
	// レスの書込みがあれば
	if($_POST['thread_name'] !== '') {
		// データベースにアクセスして値を挿入する
		$res = $db->prepare('INSERT INTO responses SET res=? ,created=Now()');
		// ?の値に配列で値を入れる
		$res->execute(array($_POST['res']));
		// index.phpを自動的に呼び出し、ポストの値を空にする
		header('Location: res.php');
		exit();
	}
}
		// 投稿したスレッド名の一覧とそれに付随するidを取得する
		$responses = $db->query('SELECT r.res FROM responses r ,threads t WHERE r.id=t.id ORDER BY r.created DESC');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>chat res</title>
	<link rel="stylesheet" href="style.css" />
<body>
	<form action="" method="post">
		<p>コメント</p>
		<textarea name="res" rows="2" cols="30"></textarea>
		<input type="submit" value="作成" />
	</form>
	<h1>レス一覧</h1>
	<!-- メッセージ一覧を表示する -->
	<!-- $responsesの配列の中身を繰り返し精査しながら$$response変数に渡し、最後まで精査が終わったら繰り返しを終える -->
	<?php if($response = $responses->fetch()): ?>
		<!-- エスケープ処理をしてhtmlに表示し、ENT_QUOTESでシングルクォーテーションとダブルクォーテーションの区別をなくす -->
	<p><?php print(htmlspecialchars($response['res'], ENT_QUOTES)); ?></p>
<?php else: ?>
	<p>投稿がありません</p>
<?php endif; ?>
</body>
</html>

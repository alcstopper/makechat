<?php
session_start();

// データベースに問い合わせ
require('dbconnect.php');
require('createdb.php');
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
$login_id=$member['id'];
// 投稿したスレッド名の一覧をユーザーのIDに関連付けて表示する
$threads = $db->query("SELECT t.* FROM members m, threads t WHERE ('{$login_id}'=t.member_id OR '{$login_id}'=t.partner_id) AND '{$login_id}'=m.id");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>makechat</title>
	<link rel="stylesheet" href="style.css" />
</head>
<header>
	<p><a href=search.php>友達検索</a></p>
</header>
<body>
	<h1>ユーザー : <?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?></h1>
	<h1>トーク一覧</h1>
	<!-- メッセージ一覧を表示する -->
	<!-- $threadsの配列の中身を繰り返し精査しながら$thread変数に渡し、最後まで精査が終わったら繰り返しを終える -->
	<?php foreach ($threads as $thread): ?>
		<!-- エスケープ処理をしてhtmlに表示し、ENT_QUOTESでシングルクォーテーションとダブルクォーテーションの区別をなくす -->
		<p><a href=ajaxres.php?t_name=<?php print(htmlspecialchars($thread['thread_name'], ENT_QUOTES)); ?>><?php print(htmlspecialchars($thread['thread_name'], ENT_QUOTES)); ?></a>
		<?php if($login_id == $thread['member_id']): ?>
		<a href="delete.php?id=<?php print(htmlspecialchars($thread['id'])); ?>">削除</a>
		<?php endif; ?>
		<?php endforeach; ?>

	</body>
	</html>

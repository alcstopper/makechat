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
	// 作成ボタンがクリックされたとき
	if(!empty($_POST)) {
		// スレッド名の書込みがあれば
		if($_POST['thread_name'] !== '') {
			// データベースにアクセスして値を挿入する
			$thread_name = $db->prepare('INSERT INTO threads SET member_id=?, thread_name=?');
			// ?の値に配列で値を入れる
			$thread_name->execute(array(
				$member['id'],
				$_POST['thread_name']));
			// スレッド内のテーブル作成
			$db->query($res_sql);
			// index.phpを自動的に呼び出し、ポストの値を空にする
			header('Location: index.php');
			exit();
		}
	}
	// 投稿したスレッド名の一覧をユーザーのIDに関連付けて表示する
	$threads = $db->query('SELECT m.name, t.* FROM members m, threads t WHERE m.id=t.member_id');
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
			<h1>ユーザー : <?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>
				<p>スレッド名を入力してください</p>
				<textarea name="thread_name" rows="2" cols="30"></textarea>
				<input type="submit" value="作成" />
		</form>
			<h1>スレッド一覧</h1>
			<!-- メッセージ一覧を表示する -->
			<!-- $threadsの配列の中身を繰り返し精査しながら$thread変数に渡し、最後まで精査が終わったら繰り返しを終える -->
			<?php foreach ($threads as $thread): ?>
				<!-- エスケープ処理をしてhtmlに表示し、ENT_QUOTESでシングルクォーテーションとダブルクォーテーションの区別をなくす -->
				<p><a href=ajaxres.php?t_name=<?php print(htmlspecialchars($thread['thread_name'], ENT_QUOTES)); ?>><?php print(htmlspecialchars($thread['thread_name'], ENT_QUOTES)); ?></a><span class="name"> /作成者:<?php print(htmlspecialchars($thread['name'], ENT_QUOTES)); ?></span></p>
			<?php endforeach; ?>
	</body>
</html>

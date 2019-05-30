<?php
session_start();
// データベースに問い合わせ
require('dbconnect.php');
// ログインしているユーザーのIDを取得する
$members = $db->prepare('SELECT * FROM members WHERE id=?');
// SESSIONのIDを使ってデータベースからIDを引っ張る
$members->execute(array($_SESSION['id']));
// $membersから$memberに対してfetchをして取得したIDを保存する
$member = $members->fetch();

if(isset($_GET['t_name'])){
	$table = $_GET['t_name'];}
	// 作成ボタンがクリックされたとき
	if(!empty($_POST)) {
		// talkの書込みがあれば
		if($_POST['talk'] !== '') {
			// データベースにアクセスして値を挿入する
			$res = $db->prepare("INSERT INTO `{$table}` SET member_id=?, talk=?");
			// ?の値に配列で値を入れる
			$res->execute(array(
				$member['id'],
				$_POST['talk']));
				// index.phpを自動的に呼び出し、ポストの値を空にする
				header('Location: ajaxres.php?t_name='.$table);
				exit();
			}
		}
		// 投稿したスレッド名の一覧とそれに付随するidを取得する
		$responses = $db->query("SELECT members.name, `{$table}`.* FROM members, `{$table}` WHERE members.id=`{$table}`.member_id");
		?>

		<!DOCTYPE html>
		<html lang="ja">
		<head>
			<meta charset="UTF-8">
			<title>chat res</title>
			<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
			<link rel="stylesheet" href="style.css" />
			<body>
				<p>レス一覧</p>
				<!-- メッセージ一覧を表示する -->
				<!-- $responsesの配列の中身を繰り返し精査しながら$$response変数に渡し、最後まで精査が終わったら繰り返しを終える -->
				<?php foreach ($responses as $response): ?>
					<!-- エスケープ処理をしてhtmlに表示し、ENT_QUOTESでシングルクォーテーションとダブルクォーテーションの区別をなくす -->
					<p><?php print(htmlspecialchars($response['talk'], ENT_QUOTES)); ?><span class="name"> /投稿者:<?php print(htmlspecialchars($response['name'], ENT_QUOTES)); ?></span></p>
				<?php endforeach; ?>
			</div>


		</body>
		</html>

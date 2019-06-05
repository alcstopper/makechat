<?php
session_start();
// データベースに問い合わせ
require('dbconnect.php');
require('header.php');
// $_POSTの値が空でなければ実行する
if(!empty($_GET)){
  $user = $_GET['usersearch'];
  // エラーチェック
  // 値が空の場合はエラー
  if($_GET['usersearch'] === ''){
    $error['usersearch'] = 'blank';
  }
  // talkの書込みがあれば
  if($_GET['usersearch'] !== '') {
    $sql = $db->prepare("SELECT id, name FROM members WHERE name=?");
    $sql->execute(array(
      $user));
    }
    $search_result = $db->query("SELECT id, name FROM members WHERE name='{$user}'");
  }
  ?>
  <!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>検索画面</title>
    <link rel="stylesheet" href="style.css" />
    <body>
      <form action="" method="get">
        <h1>友達検索</h1>
        <p>検索<input type="text" name="usersearch" size="35" maxlength="255" placeholder="ユーザー名"value="<?php print(htmlspecialchars($_GET['usersearch'],ENT_QUOTES));?>" /></p>
        <input type="submit" value="確認"/>
      </form>
      <?php if(!empty($_GET)): ?>
        <?php foreach ($search_result as $username): ?>
          <!-- エスケープ処理をしてhtmlに表示し、ENT_QUOTESでシングルクォーテーションとダブルクォーテーションの区別をなくす -->
          <p><a href=create_thread.php?id=<?php print(htmlspecialchars($username['id'], ENT_QUOTES)); ?>><?php print(htmlspecialchars($username['name'], ENT_QUOTES)); ?></a></p>
        <?php endforeach; ?>
      <?php endif; ?>
      <?php if($error['usersearch'] === 'blank'): ?>
        <p class="error">ユーザー名を入力してください</p>
      <?php endif; ?>
    </body>
    </html>

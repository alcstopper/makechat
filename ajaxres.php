<?
require('header.php');
$_GET['t_name'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>チャットページ</title>
  <link rel="stylesheet" href="style.css" />
</head>
  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script>
  var parameter = location.search;
  var url = 'http://localhost/makechat/res.php'
  var path = url + parameter;
  $(function() {
    update();
    //関数update()を1000ミリ秒間隔で呼び出す
    setInterval("update()", 1000);
  });
  function update() {
    $.ajax({
      url: path,
      dataType: 'html',
      success: function(data) {
        $('#text').html(data);
      },
      error: function(data) {
        alert('error');
      }
    });
  }
  </script>
</head>
<body>
  <div id="wrap">
    <div id="text"></div>
    <div class="bottom_box">
      <h1><?php print $_GET['t_name']; ?></h1>
      <form action="res.php?t_name=<?php print(htmlspecialchars($_GET['t_name'], ENT_QUOTES)); ?>" method="post">
        <textarea  class="talk_input" name="talk" rows="1" placeholder="メッセージを入力"></textarea>
        <input type="submit" value="投稿" />
      </form>
    </div>
  </div>
</body>
</html>

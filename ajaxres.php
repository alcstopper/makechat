<?php
$_GET['t_name'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>CSS overflow</title>
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
  <form action="res.php?t_name=<?php print(htmlspecialchars($_GET['t_name'], ENT_QUOTES)); ?>" method="post">
    <h1><?php print $_GET['t_name']; ?></h1>
    <textarea name="talk" rows="2" cols="30"></textarea>
    <input type="submit" value="投稿" />
  </form>
  <p><a href=index.php>戻る</a></p>
  <div id="text"></div>
</body>
</html>

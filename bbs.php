<?php
    date_default_timezone_set('Asia/Manila'); //フィリピン時間に設定

    // =============================  DB接続  ============================
        $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->query('SET NAMES utf8');
    // =============================  DB接続  ============================

    // =============================  DBに登録する処理  ============================
        if (!empty($_POST)) {   // つぶやくボタンを押された場合(postの場合)
            $nickname = htmlspecialchars($_POST['nickname']);
            $comment = htmlspecialchars($_POST['comment']);

            $sql = "INSERT INTO posts (nickname, comment, created) VALUES (?, ?, ?)";
            $data = [$nickname, $comment, date("Y-m-d H:i:s")];
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
        }
    // =============================  DBに登録する処理  ============================


     // =============================  DBから投稿を全て取得  ============================
        $sql = 'SELECT * FROM posts ORDER BY created DESC';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        $comments = array();
        while (true) { // ずっと繰り返す
            $rec = $stmt->fetch(PDO::FETCH_ASSOC); // 投稿を1件取り出して、$recに代入
            if ($rec == false) {
                break;
            }

            $comments[] = $rec; // $recを配列$commentsに追加
        }
    // =============================  DBから投稿を全て取得  ============================

    //DB切断
    $dbh = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-linux"></i> Oneline bbs</span></a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
        </div>
   </nav>

  <div class="container">
    <div class="row">

      <!-- 画面左側 -->
      <div class="col-md-4 content-margin-top">
        <form action="bbs.php" method="post">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="nickname" class="form-control" id="validate-text" placeholder="nickname" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group" data-validate="length" data-length="4">
              <textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="comment" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <button type="submit" class="btn btn-primary col-xs-12" disabled>つぶやく</button>
        </form>
      </div>

      <!-- 画面右側 -->
      <div class="col-md-8 content-margin-top">
          <div class="timeline-centered">
            <!-- ============ DBから取得したデータを画面に表示 ========== -->
                <?php foreach ($comments as $comment): ?>
                    <article class="timeline-entry">
                      <div class="timeline-entry-inner">
                          <div class="timeline-icon bg-success">
                              <i class="entypo-feather"></i>
                              <i class="fa fa-cogs"></i>
                          </div>
                          <div class="timeline-label">
                              <h2>
                                <a href="#"><?php echo $comment['nickname'] ?></a>
                                <span><?php echo $comment['created'] ?></span>
                                <a href="edit.php?id=<?php echo $comment["id"]; ?>" class="btn btn-success" style="color: white">編集</a>
                                <a href="delete.php?id=<?php echo $comment["id"]; ?>" class="btn btn-danger" style="color: white">削除</a>
                              </h2>
                              <p><?php echo $comment['comment'] ?></p>
                          </div>
                      </div>
                    </article>
                <?php endforeach; ?>
            <!-- ========== DBから取得したデータを画面に表示 ========== -->

            <article class="timeline-entry begin">
              <div class="timeline-entry-inner">
                  <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                      <i class="entypo-flight"></i> +
                  </div>
              </div>
            </article>
          </div>
      </div>

    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>
</body>
</html>

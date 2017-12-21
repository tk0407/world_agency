<?php
    session_start();
    require('../dbconnect.php');
    require('../functions.php');

    if (!isset($_SESSION['register'])) {
      header('Location: signup.php');
      exit();
    }

    v($_POST);

    v($_SESSION['register']);

    $email = $_SESSION['register']['email'];
    $password = $_SESSION['register']['password'];

    // 登録ボタンが押された際の処理
    if (!empty($_POST)) {
      echo '通過<br>';
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $sql = 'INSERT INTO `users` SET
        `email`=?
        ,`password`=?
        ,`created`=NOW()
        ,`updated`=NOW()
        ';
      $data = array($email,$password_hash);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      unset($_SESSION['register']);
      header('Location: thanks.php');
      exit();
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../assets/ico/favicon.png">

  <title>World Agency</title>

  <link href="../assets/css/hover_pack.css" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link href="../assets/css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../assets/css/main.css" rel="stylesheet">
  <link href="../assets/css/colors/color-74c9be.css" rel="stylesheet">    
  <link href="../assets/css/animations.css" rel="stylesheet">
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet">

  </head>

  <body style="margin-top: ; background: #FFFFFF;">
  <br>
  <br>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">アカウント情報確認</h2>
        <div class="row">
          <div class="col-xs-8">
            <div>
              <span>メールアドレス</span>
              <p class="lead"><?php echo htmlspecialchars($email); ?></p>
            </div>
            <div>
              <span>パスワード</span>
              <!-- ② -->
              <p class="lead">●●●●●●</p>
            </div>
            <!-- ③ -->
            <form method="POST" action="check.php">
              <!-- ④ -->
              <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> | 
              <!-- ⑤ -->
              <input type="hidden" name="action" value="submit">
              <input type="submit" class="btn btn-primary" value="ユーザー登録">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/jquery-3.1.1.js"></script>
  <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="../assets/js/bootstrap.js"></script>
</body>
</html>
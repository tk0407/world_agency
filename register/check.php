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
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body style="margin-top: 60px">
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
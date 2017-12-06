<?php
    session_start();
    require('../dbconnect.php');
    require('../functions.php');

    $errors = array();
    $email = '';
    $password = '';

    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
      $_POST['input_email'] = $_SESSION['register']['email'];
    }


    v($_POST);

    if(!empty($_POST)) {
      $email = $_POST['input_email'];
      if (!isset($_REQUEST['action'])) {
          $password = $_POST['input_password'];
      }

      // メールアドレスの空チェック
      if ($email == '') {
          $errors['email'] = 'blank';
      }


      $count = strlen($password);
      if ($password == '') {
          $errors['password'] = 'blank';
      } elseif ($count < 4 || 16 < $count) {
          $errors['password'] = 'length';
      }

      // メールアドレス重複チェック 2017/11/15
      // SELECTのときはFETCHもセット FETCHしないと取ってきただけになってしまう
      if (empty($errors)) {
          $sql = 'SELECT COUNT(*) AS cnt FROM users WHERE email=?';
          $data = array($email);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
          $record = $stmt->fetch(PDO::FETCH_ASSOC);
          if ($record['cnt'] > 0) {
              $errors['email'] = 'duplicate';
          }

      }

      v($errors);

      if (empty($errors)) {
          // バリデーション成功時の処理
          $_SESSION['register']['email'] = $_POST['input_email'];
          $_SESSION['register']['password'] = $_POST['input_password'];

          header('Location: check.php');
          exit();
      }
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body style="margin-top: 60px;">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">アカウント作成</h2>
        <form method="POST" action="signup.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="input_email"  value="<?php echo htmlspecialchars($email); ?>" class="form-control" id="email" placeholder="example@gmail.com">
            <?php  if(isset($errors['email']) && $errors['email'] == 'blank'){ ?>
            <p class="text-danger">メールアドレスを入力してください</p>
            <?php  } ?>
            <?php  if(isset($errors['email']) && $errors['email'] == 'duplicate'){ ?>
            <p class="text-danger">そのメールアドレスは既に登録されています</p>
            <?php  } ?>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
            <?php  if(isset($errors['password']) && $errors['password'] == 'blank'){ ?>
            <p class="text-danger">パスワードを入力してください</p>
            <?php  } ?>
            <?php  if(isset($errors['password']) && $errors['password'] == 'length'){ ?>
            <p class="text-danger">パスワードを４〜１６文字で入力してください</p>
            <?php  } ?>
          </div>
          <input type="submit" class="btn btn-default" value="確認">
          <a href="../signin.php" style="float: right; padding-top: 6px;" class="text-success">サインイン</a>
        </form>
      </div>

    </div>
  </div>

  <script type="../assets/js/jquery.js"></script>
  <script type="../assets/js/bootstrap.js"></script>
</body>
</html>
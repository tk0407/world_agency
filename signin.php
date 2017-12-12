<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $errors = array();
    $email = '';
    $password = '';


    if (!empty($_POST)) {
        $email = $_POST['input_email'];
        $password = $_POST['input_password'];

        // どちらかが空だった場合blankバリデーション
        if ($email == '' || $password == '') {
            $errors['signin'] = 'blank';
        } else {
            // データベースとの照合
            $sql = 'SELECT * FROM `users` WHERE `email`=?';
            $data = array($email);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            v($record);

            // $recordがfalse == データ0件（メールアドレスが間違っている）
            if ($record == false) {
                $errors['signin'] = 'failed';
            } else {
                $hash_password = $record['password'];
                $verify = password_verify($password, $hash_password);
                if ($verify == true) {
                    // サインイン処理
                    $_SESSION['signin_user']['id'] = $record['id'];

                    header('Location: mypage.php');
                    exit();
                } else {
                    $errors['signin'] = 'failed';
                }
            }
        }
    }

    v($errors);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">サインイン</h2>
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com" value="<?php echo $email; ?>">
          <?php if (isset($errors['signin']) && $errors['signin'] == 'blank'){ ?>
            <p class="text-danger">メールアドレスとパスワードを正しく入力してください</p>
          <?php } ?>
          <?php if(isset($errors['signin']) && $errors['signin'] == 'failed') { ?>
            <p class="text-danger">サインインに失敗しました</p>
          <?php } ?>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
          </div>
          <input type="submit" class="btn btn-info" value="サインイン">
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
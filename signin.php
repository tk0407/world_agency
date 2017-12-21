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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="assets/ico/favicon.png">

  <title>World Agency</title>

  <link href="assets/css/hover_pack.css" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/colors/color-74c9be.css" rel="stylesheet">    
  <link href="assets/css/animations.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">

  </head>

  <body style="margin-top:50px ; background: #FFFFFF;">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 centered">
        <img src="assets/img/WA_logo.png" width="100">
        <br>
        <br>
      </div>
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">World Agency サインイン</h2>
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
          <input type="submit" class="btn btn-wa" value="サインイン">
          <a href="register/signup.php" style="float: right; padding-top: 6px;" class="text-success">アカウント登録</a>
        </form>
      </div>
      <div class="col-xs-8 col-xs-offset-2 centered">
      <br>
      <br>
      © 2018 World Agency
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>



</body>
</html>
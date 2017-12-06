<?php
    session_start();
    require('../dbconnect.php');
    require('../functions.php');
    require('../signin_check.php');

    // if (!isset($_REQUEST['edit_id'])) {
    //    header('Location: index.php');
    //    exit();
    // }

    $errors = array();
    $firstname = '';
    $lastname = '';
    $email = '';
    $password = '';
    $countries = '';
    $adress = '';
    $sex = '';
    $phone = '';
    $profile = '';
    $language = '';
    $paypal_adress = '';
    $bitcoin_adress = '';
    $bank_name = '';
    $account_type = '';
    $account_name = '';
    $branch_code = '';
    $account_number = '';
    $img_name = "../user_profile_img/".$signin_user['img_name'];
    $evaluates_id = '';

    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
      $_POST['name'] = $_SESSION['register']['name'];
      $_POST['email'] = $_SESSION['register']['email'];
    }


    if(!empty($_POST)) {
      $email = $_POST['email'];
      if (!isset($_REQUEST['action'])) {
          $password = $_POST['password'];
      }

      // メールアドレスの空チェック
      if ($email == '') {
          $errors['email'] = 'blank';
      }


      v($_POST);
      v($errors);


      $count = strlen($password);
      if ($password == '') {
          $errors['password'] = 'blank';
      } elseif ($count < 4 || 16 < $count) {
          $errors['password'] = 'length';
      }

      $file_name = "";
      if (!isset($_REQUEST['action'])) {
          $file_name = $_FILES['input_img_name']['name'];
      }

      if (!empty($file_name)) {
        echo 'hoge';
          // 画像選択時のバリデーション
          $file_type = substr($file_name, -3);
          $file_type = strtolower($file_type); // 自己代入
          if ($file_type != 'png' && $file_type != 'jpg' && $file_type != 'gif') {
        echo 'hoge2';
            $errors['img_name'] = 'type';

          }
      }


      // メールアドレス重複チェック 2017/11/15
      // SELECTのときはFETCHもセット FETCHしないと取ってきただけになってしまう

      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $email = $_POST['email'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $countries = $_POST['countries'];
      $adress = $_POST['adress'];
      $sex = $_POST['sex'];
      $phone = $_POST['phone'];
      $profile = $_POST['profile'];
      $language = $_POST['language'];
      $paypal_adress = $_POST['paypal_adress'];
      $bitcoin_adress = $_POST['bitcoin_adress'];
      $bank_name = $_POST['bank_name'];
      $account_type = $_POST['account_type'];
      $account_name = $_POST['account_name'];
      $branch_code = $_POST['branch_code'];
      $account_number = $_POST['account_number'];
      // if (isset($_POST['input_img_name'])) {
      //   $img_name = $_POST['input_img_name'];
      // }else{
      //   $img_name = $signin_user['img_name'];
      // }
      
      // $evaluates_id = $_POST['evaluates_id'];


      if (empty($errors)) {

          $submit_file_name = $signin_user['img_name'];
          if ($_FILES['input_img_name']['name'] != '') {
              $date_str = date('YmdHis');
              $submit_file_name = $date_str . $file_name;
              move_uploaded_file($_FILES['input_img_name']['tmp_name'], '../user_profile_img/' . $submit_file_name);
          }

          $sql = 'UPDATE `users` SET `firstname` =? , `lastname` =? , `email` =? , `password` =? , `countries` =? , `adress` =? , `sex` =?, `phone` =? , `profile` =? , `language` =? , `paypal_adress` =? , `bitcoin_adress` =? , `bank_name` =? , `account_type` =?, `account_name` =? , `branch_code` =? , `account_number` =? , `img_name` =?, `updated`=NOW() WHERE `id`=?'; // SQL文を文字で用意
          $data = array($firstname,$lastname,$email,$password,$countries,$adress,$sex,$phone,$profile,$language,$paypal_adress,$bitcoin_adress,$bank_name,$account_type,$account_name,$branch_code,$account_number,$submit_file_name,$signin_user['id']); // ?に入れるデータを配列で用意
          $stmt = $dbh->prepare($sql); // SQL文をデータベースにセット
          v($data);
          $stmt->execute($data); // SQL文を実行

          header("Location: edit_profile.php");
          exit(); //ここで処理を止める。
      }

      }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>World Agency：プロフィール編集画面</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
  <body style="margin-top: 60px; background: #E4E6EB;">
  <?php require('../navbar.php'); ?>

  <div class="row mt centered ">
    <div class="col-xs-8 col-xs-offset-2">
      <h2 class="text-center content_header">プロフィール編集画面</h2>
      <hr>
    </div><!-- /col-lg-4 -->
  </div><!-- /row -->

  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <form method="POST" action="edit_profile.php" enctype="multipart/form-data">
          
          <div class="form-group text-center">
            <div class="form-group">
              <img src="../user_profile_img/<?php echo htmlspecialchars($signin_user['img_name']); ?>" width="100" class="img-responsive img-thumbnail img-circle">
            </div>
            <input type="file" name="input_img_name" id="img_name" accept="image/*" class="center-block">
            <?php  if(isset($errors['img_name']) && $errors['img_name'] == 'type'){ ?>
            <p class="text-danger">拡張子が「jpg」「png」「gif」の画像を選択してください</p>
            <?php  } ?>
          </div>

          <div class="form-group">
            <label for="firstname">名</label>
            <input type="text" name="firstname"  value="<?php echo htmlspecialchars($signin_user['firstname']); ?>" class="form-control" id="firstname" placeholder="名">
          </div>

          <div class="form-group">
            <label for="lastname">姓</label>
            <input type="text" name="lastname"  value="<?php echo htmlspecialchars($signin_user['lastname']); ?>" class="form-control" id="lastname" placeholder="姓">
          </div>

          <div class="form-group">
            <label for="countries">国</label>
            <input type="text" name="countries"  value="<?php echo htmlspecialchars($signin_user['countries']); ?>" class="form-control" id="countries" placeholder="選択する">
          </div>

          <div class="form-group">
            <label for="adress">住所</label>
            <input type="text" name="adress"  value="<?php echo htmlspecialchars($signin_user['adress']); ?>" class="form-control" id="adress" placeholder="住所">
          </div>

          <div>
            <label for="sex">性別</label><br>
            <?php if ($signin_user['sex']=='female'): ?>
            <input type="radio" name="sex" value="male" id="sex">男
            <input type="radio" name="sex" value="female" id="sex" checked>女
            <?php else: ?>
            <input type="radio" name="sex" value="male" id="sex" checked>男
            <input type="radio" name="sex" value="female" id="sex">女
            <?php endif; ?>
          </div><br>

          <div class="form-group">
            <label for="phone">電話番号</label>
            <input type="text" name="phone"  value="<?php echo htmlspecialchars($signin_user['phone']); ?>" class="form-control" id="phone" placeholder="090-1234-5678">
          </div>

          <div class="form-group">
            <label for="profile">自己紹介</label>
            <input type="text" name="profile"  value="<?php echo htmlspecialchars($signin_user['profile']); ?>" class="form-control" id="profile" placeholder="まだ入力されていません">
          </div>

          <div class="form-group">
            <label for="language">使用可能な言語</label>
            <input type="text" name="language"  value="<?php echo htmlspecialchars($signin_user['language']); ?>" class="form-control" id="language" placeholder="日本語,英語(,区切りで入力してください)">
          </div>

          <div class="form-group">
            <label for="paypal_adress">Paypal受け取り用メールアドレス</label>
            <input type="text" name="paypal_adress"  value="<?php echo htmlspecialchars($signin_user['paypal_adress']); ?>" class="form-control" id="paypal_adress" placeholder="abc@world.com">
          </div>

          <div class="form-group">
            <label for="bitcoin_adress">ビットコイン受け取り用アドレス</label>
            <input type="text" name="bitcoin_adress"  value="<?php echo htmlspecialchars($signin_user['bitcoin_adress']); ?>" class="form-control" id="bitcoin_adress" placeholder="ビットコイン">
          </div>

          <div class="form-group">
            <label for="bank_name">銀行名</label>
            <input type="text" name="bank_name"  value="<?php echo htmlspecialchars($signin_user['bank_name']); ?>" class="form-control" id="bank_name" placeholder="〇〇銀行">
          </div>

          <div>
            <label for="account_type">口座種別</label><br>
            <?php if ($signin_user['account_type']=='touza'): ?>
            <input type="radio" name="account_type" value="nomal" id="account_type">普通
            <input type="radio" name="account_type" value="touza" id="account_type" checked>当座
            <?php else: ?>
            <input type="radio" name="account_type" value="nomal" id="account_type" checked>普通
            <input type="radio" name="account_type" value="touza" id="account_type">当座
            <?php endif; ?>
          </div><br>

          <div class="form-group">
            <label for="account_name">口座名義</label>
            <input type="text" name="account_name"  value="<?php echo htmlspecialchars($signin_user['account_name']); ?>" class="form-control" id="account_name" placeholder="本人氏名">
          </div>

          <div class="form-group">
            <label for="branch_code">支店番号</label>
            <input type="text" name="branch_code"  value="<?php echo htmlspecialchars($signin_user['branch_code']); ?>" class="form-control" id="branch_code" placeholder="123">
          </div>

          <div class="form-group">
            <label for="account_number">口座番号</label>
            <input type="text" name="account_number"  value="<?php echo htmlspecialchars($signin_user['account_number']); ?>" class="form-control" id="account_number" placeholder="1234567">
          </div>

          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email"  value="<?php echo htmlspecialchars($signin_user['email']); ?>" class="form-control" id="email" placeholder="example@gmail.com">
            <?php  if(isset($errors['email']) && $errors['email'] == 'blank'){ ?>
            <p class="text-danger">メールアドレスを入力してください</p>
            <?php  } ?>
            <?php  if(isset($errors['email']) && $errors['email'] == 'duplicate'){ ?>
            <p class="text-danger">そのメールアドレスは既に登録されています</p>
            <?php  } ?>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
            <?php  if(isset($errors['password']) && $errors['password'] == 'blank'){ ?>
            <p class="text-danger">パスワードを入力してください</p>
            <?php  } ?>
            <?php  if(isset($errors['password']) && $errors['password'] == 'length'){ ?>
            <p class="text-danger">パスワードを４〜１６文字で入力してください</p>
            <?php  } ?>
          </div>
          <input type="submit" class="btn btn-default" value="確認">
        </form>
      </div>

    </div>
  </div>

  <script type="../assets/js/jquery.js"></script>
  <script type="../assets/js/bootstrap.js"></script>
</body>
</html>
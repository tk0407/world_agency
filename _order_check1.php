<?php
    session_start();
    // requireでfunctionsの関数を呼び出す。linkのようなモノ
    require('dbconnect.php');
    require('functions.php');
    require('signin_check.php');

    // $signin_user['id'] = 1; //後でsignin idをここに表示できるようにする。

    if(!isset($_SESSION['register'])) {
      header('Location: _order_detail1.php');
      exit();
    }
    // サインインユーザーが依頼をする時、ユーザーidはclient_idに代入される。
    if (!empty($_SESSION['signin_user']['id'])) {
      $client_id = $_SESSION['signin_user']['id'];
    }

    // v($_POST);

    // v($_SESSION['register']);

    $city_id = $_SESSION['register']['city'];
    $item_name = $_SESSION['register']['item_name'];
    $amount = $_SESSION['register']['amount'];
    $order_price = $_SESSION['register']['order_price'];
    $delivery_date = $_SESSION['register']['delivery_date'];
    $publication_period = $_SESSION['register']['publication_period'];
    $images = $_SESSION['register']['images'];
    $detail = $_SESSION['register']['detail'];
    $attached_file = $_SESSION['register']['attached_file'];
    $category = 1;

    $sql = 'SELECT * FROM `cities` WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $city_id, PDO::PARAM_INT); //インジェクション対策
    $stmt->execute();
    $city = $stmt->fetch(PDO::FETCH_ASSOC);
    // v($city);

    // 登録ボタンが押された時の処理
    if (!empty($_POST)) {
        echo '通過<br>';
        // $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO `orders` SET
          `city_id`=?
          ,`category`=?
          ,`item_name`=?
          ,`amount`=?
          ,`order_price`=?
          ,`delivery_date`=?
          ,`publication_period`=?
          ,`images`=?
          ,`detail`=?
          ,`attached_file`=?
          ,`client_id`=?
          ,`created`=NOW()
          ';
          // 上記が雛形の書き方
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $city_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $category, PDO::PARAM_STR);
        $stmt->bindParam(3, $item_name, PDO::PARAM_STR);
        $stmt->bindParam(4, $amount, PDO::PARAM_STR);
        $stmt->bindParam(5, $order_price, PDO::PARAM_STR);
        $stmt->bindParam(6, $delivery_date, PDO::PARAM_STR);
        $stmt->bindParam(7, $publication_period, PDO::PARAM_STR);
        $stmt->bindParam(8, $images, PDO::PARAM_STR);
        $stmt->bindParam(9, $detail, PDO::PARAM_STR);
        $stmt->bindParam(10, $attached_file, PDO::PARAM_STR);
        $stmt->bindParam(11, $client_id, PDO::PARAM_STR);
        $stmt->execute();
s
        unset($_SESSION['register']);
        header('Location: thanksorder.php');
        exit();

    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>World Agency</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="shortcut icon" href="assets/ico/favicon.png">
  <link href="assets/css/hover_pack.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/colors/color-74c9be.css" rel="stylesheet">
  <link href="assets/css/animations.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
  <?php require('navbar.php');?>
  <div style="margin-top: 50px; z-index: 1; background-image: url(assets/img/portfolio/formback3.jpg); background-position:center center; background-repeat:no-repeat; background-attachment: fixed; background-size: cover;">
    <div class="container" style="opacity: 0.95;">
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 thumbnail">
          <h2 class="text-center content_header">依頼 情報確認</h2>
          <div class="row">
            <div class="col-xs-4">
              <img src="order_images/<?php echo $images;?>" class="img-responsive img-thumbnail">
            </div>
            <div class="col-xs-8">
              <div>
                <span>都市</span>
                <p class="lead"><?php echo $city['city_name'];?></p>
              </div>
              <div>
                <span>商品名</span>
                <p class="lead"><?php echo $item_name;?></p>
              </div>
              <div>
                <span>個数</span>
                <p class="lead"><?php echo $amount;?></p>
              </div>
              <div>
                <span>希望価格</span>
                <p class="lead"><?php echo $order_price;?></p>
              </div>
              <div>
                <span>希望受取日</span>
                <p class="lead"><?php echo $delivery_date;?></p>
              </div>
              <div>
                <span>掲載期間</span>
                <p class="lead"><?php echo $publication_period;?></p>
              </div>
              <!-- ↓もし,$imagesが空じゃなかったら発動する、空だったらスルーの処理を行う -->
              <div>
                <span>参考画像</span>
                <p class="lead"><?php if (!empty($images)) {
                  echo $images;
                } ?></p>
              </div>
              <div>
                <span>詳細</span>
                <p class="lead"><?php echo $detail;?></p>
              </div>
              <div>
                <?php if (!empty($attached_file)) { ?>
                <span>添付ファイル</span>
                  <p class="lead">
                    <?php echo $attached_file ;?>
                    <?php } else { echo ""; ?>
                  </p>
                <?php } ?>
              </div>
              <!-- ③ -->
              <form method="POST" action="_order_check1.php">
                <!-- ④ -->
                <a href="_order_detail1.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> |
                <!-- ⑤ -->
                <input type="hidden" name="action" value="submit">
                <input type="submit" class="btn btn-primary" value="依頼する">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require('footer.php');?>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
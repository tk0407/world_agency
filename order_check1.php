<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    if(!isset($_SESSION['register'])) {
      header('Location: order_detail1.php');
      exit();
    }

    v($_POST);

    v($_SESSION['register']);

    $item_name = $_SESSION['register']['item_name'];
    $amount = $_SESSION['register']['amount'];
    $order_price = $_SESSION['register']['order_price'];
    $delivery_date = $_SESSION['register']['delivery_date'];
    $publication_period = $_SESSION['register']['publication_period'];
    $images = $_SESSION['register']['images'];
    $detail = $_SESSION['register']['detail'];
    $attached_file = $_SESSION['register']['attached_file'];

    // 登録ボタンが押された時の処理
    if (!empty($_POST)) {
        echo '通過<br>';
        // $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO `orders` SET
          `item_name`=?
          ,`amount`=?
          ,`order_price`=?
          ,`delivery_date`=?
          ,`publication_period`=?
          ,`images`=?
          ,`detail`=?
          ,`attached_file`=?
          ,`created`=NOW()
          ';
          // 上記が雛形の書き方
        $data = array($item_name,$amount,$order_price,$delivery_date,$publication_period,$images,$detail,$attached_file);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        unset($_SESSION['register']);
        header('Location: thanksorder.php');
        exit();

    }
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
        <h2 class="text-center content_header">アカウント情報確認</h2>
        <div class="row">
          <div class="col-xs-4">
            <img src="order_images/<?php echo $images;?>" class="img-responsive img-thumbnail">
          </div>
          <div class="col-xs-8">
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
            <div>
              <span>参考画像</span>
              <p class="lead"><?php echo $images;?></p>
            </div>
            <div>
              <span>詳細</span>
              <p class="lead"><?php echo $detail;?></p>
            </div>
            <div>
              <span>添付ファイル</span>
              <p class="lead"><?php echo $attached_file;?></p>
            </div>
            <!-- ③ -->
            <form method="POST" action="order_check1.php">
              <!-- ④ -->
              <a href="order_detail1.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> |
              <!-- ⑤ -->
              <input type="hidden" name="action" value="submit">
              <input type="submit" class="btn btn-primary" value="依頼する">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
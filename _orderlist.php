<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    // require('signin_check.php');

    $_REQUEST['user_id'] = 2;
    if (!isset($_REQUEST['user_id'])) {
        // header('Location: users.php');
        // exit();
    }

    $user_id = $_REQUEST['user_id'];

    // SELECT文 WEHEREの条件等を文法で覚えておく
    $sql = 'SELECT * FROM `users` WHERE id = ?';
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // v($user);
    // v($signin_user);


    // フィード取得
    $sql = 'SELECT * FROM orders WHERE user_id = ? ORDER BY updated DESC';
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $orders = array();
    while(true){
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record == false) {
            break;
        }
        $orders[] = $record;
    }
    $c = count($orders);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px; background: #E4E6EB;">
  <?php require('navbar.php'); ?>

  <div class="container">
    <div class="row mt centered ">
      <div class="col-xs-4 col-xs-offset-4">
        <h3>取引一覧</h3>
        <hr>
      </div><!-- /col-lg-4 -->
    </div><!-- /row -->


      <div class="col-xs-12">
        <!-- タイムライン -->
        <?php for($i=0;$i<$c;$i++){ ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-2">
                <img src="order_images/<?php echo $orders[$i]['images']; ?>" width="80">
              </div>
              <div class="col-xs-8">
                <a href=""><span style="font-size: 24px;"><?php echo $orders[$i]['title'] ?><?php echo $orders[$i]['item_name'] ?></span></a><br>
                個数　<?php echo $orders[$i]['amount']; ?>個　依頼日時　<?php echo $orders[$i]['created']; ?>
              </div>
              <div class="col-xs-2">
                <a href="agentlist.php?orders_id=<?php echo $orders[$i]['id'] ?>">
                <button class="btn btn-info btn-block">確認</button>
                </a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php
session_start();
require('dbconnect.php');
require('functions.php');
require('signin_check.php');

    // if (!isset($_REQUEST['orders_id']) && ($_POST['feed'])) {
    //     header('Location: users.php');
    //     exit();
    // }

if (isset($_REQUEST['orders_id'])) {
  $orders_id = $_REQUEST['orders_id'];

      // オーダー情報取得
  $sql = 'SELECT * FROM orders WHERE id = ?';
  $data = array($orders_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $order = $stmt->fetch(PDO::FETCH_ASSOC);

  $agent_id = $order['agent_id'];
  $client_id = $order['client_id'];

      // エージェント情報取得
  $sql = 'SELECT * FROM users WHERE id = ?';
  $data = array($agent_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $agent = $stmt->fetch(PDO::FETCH_ASSOC);

      // オファー情報取得（オーダーとエージェントで指定）
  $sql = 'SELECT * FROM offers WHERE agent_id = ? AND order_id = ?';
  $data = array($agent_id,$orders_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $offer = $stmt->fetch(PDO::FETCH_ASSOC);

}

    // メッセージの登録
if(!empty($_POST)){

 $message = $_POST['feed'];

       // バリデーション
 if ($message == '') {
   $errors['feed'] = 'blank';
 }

       // if ($feed_img_name == '') {
       //     $errors['feed_img_name'] = 'blank';
       // }

 if(empty($errors)){

   $orders_id = $_POST['orders_id'];
           // DBへ登録
   $sql = 'INSERT INTO messages SET message=?, sender=?, order_id=?, `created`=NOW()';
   $data = array($message, $signin_user['id'],$orders_id);
   $stmt = $dbh->prepare($sql);
   $stmt->execute($data);

   header('Location: matchingorder.php?orders_id=' . $order['id']);
   exit();
 }
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

  <body style="margin-top: ; background: #FFFFFF;">
    <?php require('navbar.php'); ?>

    <! ========== BLOG POSTS ==================================================================================================== 
    =============================================================================================================================>    
    <div id="white">
      <div class="container"> 


        <!-- -------------商品情報-------------------- -->

        <div class="row mt centered ">
          <div class="col-lg-4 col-lg-offset-4">
            <h3>決済ページ</h3>
            <hr>
          </div><!-- /col-lg-4 -->
        </div><!-- /row -->

        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
              <ul class="list-group" id="contact-list">
                <li class="list-group-item">
                  <div class="col-xs-2">
                    <img src="user_profile_img/<?php echo $agent['img_name']; ?>"  class="img-circle" width="80">
                    <img src="order_images/<?php echo $order['images']; ?>" width="80">
                  </div>
                  <div class="col-xs-10 centered">
                    <strong><i class="fa fa-cc-paypal fa-2x" aria-hidden="true"></i> エージェントの Paypal支払先アドレス</strong><br><br>
                  <?php echo $agent['paypal_adress']; ?><br><br>
                  <strong><i class="fa fa-jpy fa-2x" aria-hidden="true"></i>支払金額</strong><br><br>
                  <?php echo $offer['offer_price']; ?> 円
                  </div>
                  <div class="clearfix"></div>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- -------------決済ボタン-------------------- -->

        <?php if ($order['progress'] == 5 && $signin_user['id'] == $order['client_id']): ?>
          <div class="container">
            <div class="row">
              <div class="col-xs-4 col-xs-offset-4">
                <a href="agentreview.php?agent_id=<?php echo $agent['id'] ?>&order_id=<?php echo $order['id'] ?>">
                  <button class="btn btn-warning btn-block">決済する
                  </button>
                </a>
              </div>
            </div>
          </div>
        <?php endif ?>

      </div><!-- /container -->
    </div><!-- /black -->
    <br>

<?php require('footer.php'); ?>

    </body>
    </html>

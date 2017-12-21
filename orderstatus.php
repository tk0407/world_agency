<?php
session_start();
require('dbconnect.php');
require('functions.php');
require('signin_check.php');

if (!isset($_REQUEST['user_id'])) {
  header('Location: mypage.php');
  exit();
}

if ($_REQUEST['user_id'] != $signin_user['id']) {
  echo '不正なアクセスです';
  header('Location: mypage.php');
  exit();
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


    // クライアント側フィード取得
$sql = 'SELECT * FROM orders WHERE client_id = ? ORDER BY updated DESC';
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


    // エージェント側フィード取得
$sql = 'SELECT * FROM offers LEFT JOIN orders ON orders.id = offers.order_id WHERE offers.agent_id = ?';
$data = array($user_id);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$agent = array();
while(true){
  $record = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($record == false) {
    break;
  }
  $agent[] = $record;
}
$ca = count($agent);

// v($agent);

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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />

  </head>

  <body style="margin-top: ; background: #FFFFFF;">
    <?php require('navbar.php'); ?>

    <!-- ---------------------------オファー一覧------------------------------- -->

    <div id="white">
      <div class="container">
        <div class="row mt centered ">
          <div class="col-xs-8 col-xs-offset-2">
            <h3><?php echo $signin_user['firstname']; ?>さんが出しているオーダーリスト</h3>
            <hr>
          </div><!-- /col-lg-4 -->
        </div><!-- /row -->


        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
          <!-- タイムライン -->
          <?php for($i=0;$i<$c;$i++){ ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-3 centered">
                <img src="order_images/<?php echo $orders[$i]['images']; ?>" width="55">
              </div>
              <div class="col-xs-6">
                <a href=""><span style="font-size: 24px;">
                <?php if (!empty($orders[$i]['item_name'])) { ?>
                <?php echo $orders[$i]['item_name'];?>
                <?php } else { echo $orders[$i]['title'];?>
                <?php } ?>
                </span></a><br>
                個数<?php if (!empty($orders[$i]['amount'])) { ?>
                    <?php echo $orders[$i]['amount']; ?>個
                <?php } elseif (!empty($orders[$i]['file'])) { ?>
                    <?php echo $orders[$i]['file']; ?>つ
                <?php } elseif (!empty($orders[$i]['draft'])) { ?>
                    <?php echo $orders[$i]['draft'];?>枚
                <?php } ?>
                　依頼日時　<?php echo $orders[$i]['created']; ?>
              </div>
              <div class="col-xs-3 centerd">
                <?php if ($orders[$i]['flag'] == 0): ?>
                  <a href="offeragentlist.php?orders_id=<?php echo $orders[$i]['id'] ?>">
                    <button class="btn btn-info btn-block">オファー受付中</button>
                  </a>
                <?php elseif($orders[$i]['flag'] == 1): ?>
                  <a href="offeragentlist.php?orders_id=<?php echo $orders[$i]['id'] ?>">
                    <button class="btn btn-info btn-block">オファー受付中</button>
                  </a><i class="fa fa-hand-paper-o faa-flash animated" aria-hidden="true"></i> オファーあり
                <?php elseif($orders[$i]['flag'] == 2): ?>
                  <a href="matchingorder.php?orders_id=<?php echo $orders[$i]['id'] ?>">
                    <button class="btn btn-danger btn-block">取引中</button>
                  </a>
                <?php elseif($orders[$i]['flag'] == 3): ?>
                  <a href="matchingorder.php?orders_id=<?php echo $orders[$i]['id'] ?>">
                    <button class="btn btn-success btn-block">取引完了</button>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>

      <!-- ------------------------引き受けている依頼---------------------------------- -->

      <div class="container">
        <div class="row mt centered ">
          <div class="col-xs-8 col-xs-offset-2">
            <h3><?php echo $signin_user['firstname']; ?>さんが引き受けているオーダーリスト</h3>
            <hr>
          </div><!-- /col-lg-4 -->
        </div><!-- /row -->


        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
          <!-- タイムライン -->
          <?php for($i=0;$i<$ca;$i++){ ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-3 centered">
                <img src="order_images/<?php echo $agent[$i]['images']; ?>" width="55">
              </div>
              <div class="col-xs-6">
                <a href=""><span style="font-size: 24px;">
                <?php if (!empty($agent[$i]['item_name'])) { ?>
                <?php echo $agent[$i]['item_name'];?>
                <?php } else { echo $agent[$i]['title'];?>
                <?php } ?>
                </span></a><br>
                個数<?php if (!empty($agent[$i]['amount'])) { ?>
                    <?php echo $agent[$i]['amount']; ?>個
                <?php } elseif (!empty($agent[$i]['file'])) { ?>
                    <?php echo $agent[$i]['file']; ?>つ
                <?php } elseif (!empty($agent[$i]['draft'])) { ?>
                    <?php echo $agent[$i]['draft'];?>枚
                <?php } ?>
                　依頼日時　<?php echo $agent[$i]['created']; ?>
              </div>
              <div class="col-xs-3">
                <?php if ($agent[$i]['flag'] == 0 || $agent[$i]['flag'] == 1): ?>
                  <a href="waitingoffer.php?offer_id=<?php echo $agent[$i]['order_id'] ?>">
                    <button class="btn btn-info btn-block">オファー未承認</button>
                  </a>
                <?php elseif($agent[$i]['flag'] == 2 && $agent[$i]['agent_id'] != $user_id): ?>
                  <button class="btn btn-secondary btn-block">不成立</button>
                <?php elseif($agent[$i]['flag'] == 2 && $agent[$i]['agent_id'] == $user_id): ?>
                  <a href="matchingorder.php?orders_id=<?php echo $agent[$i]['order_id'] ?>">
                    <button class="btn btn-danger btn-block">取引中</button>
                  </a>
                <?php elseif($agent[$i]['flag'] == 3): ?>
                  <a href="matchingorder.php?orders_id=<?php echo $agent[$i]['id'] ?>">
                    <button class="btn btn-success btn-block">取引完了</button>
                  </a>
                <?php endif; ?>

              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>


<?php require('footer.php'); ?>

    <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/retina.js"></script>


      <script>
        $(window).scroll(function() {
         $('.si').each(function(){
           var imagePos = $(this).offset().top;

           var topOfWindow = $(window).scrollTop();
           if (imagePos < topOfWindow+400) {
             $(this).addClass("slideUp");
           }
         });
       });
     </script>    



     <script src="assets/js/jquery.js"></script>
     <script src="assets/js/bootstrap.js"></script>
    </body>
    </html>

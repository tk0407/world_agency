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


        // クライアント情報取得
  $sql = 'SELECT * FROM users WHERE id = ?';
  $data = array($client_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $client = $stmt->fetch(PDO::FETCH_ASSOC);

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

   // v($_POST);

   $orders_id = $_POST['orders_id'];
   $client_id = $_POST['client_id'];
   $agent_id = $_POST['agent_id'];

   // receiverを特定
   if ($signin_user['id'] == $agent_id) {
     $receiver = $client_id;
   }elseif ($signin_user['id'] == $client_id) {
     $receiver = $agent_id;
   }

   // DBへ登録
   $sql = 'INSERT INTO messages SET message=?, sender=?, receiver=?, order_id=?, `created`=NOW()';
   $data = array($message, $signin_user['id'],$receiver,$orders_id);
   $stmt = $dbh->prepare($sql);
   $stmt->execute($data);

   header('Location: matchingorder.php?orders_id=' . $order['id']);
   exit();
 }
}


    // メッセージ取得
$sql = 'SELECT * FROM messages WHERE order_id = ? ORDER BY updated ASC';
$data = array($orders_id);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$messages = array();
while(true){
  $message = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($message == false) {
    break;
  }
  $messages[] = $message;
}
$c = count($messages);

    // v($signin_user);
    // v($agent);
    // v($messages);
    // v($offer);

    // v($signin_user['img_name']);
    // v($agent['img_name']);

// 購入通知送信
if (!empty($_REQUEST['buy'])) {

  $orders_id = $_REQUEST['buy'];

    $sql = 'UPDATE orders SET progress = ? WHERE id = ?'; // SQL文を文字で用意
    $data = array(3,$_REQUEST['buy']); // ?に入れるデータを配列で用意
    $stmt = $dbh->prepare($sql); // SQL文をデータベースにセット
    v($data);
    $stmt->execute($data); // SQL文を実行

    header('Location: matchingorder.php?orders_id=' . $orders_id);
    exit();

  }

// 発送完了通知送信
  if (!empty($_REQUEST['ship'])) {

    $orders_id = $_REQUEST['ship'];

    $sql = 'UPDATE orders SET progress = ? WHERE id = ?'; // SQL文を文字で用意
    $data = array(4,$_REQUEST['ship']); // ?に入れるデータを配列で用意
    $stmt = $dbh->prepare($sql); // SQL文をデータベースにセット
    v($data);
    $stmt->execute($data); // SQL文を実行

    header('Location: matchingorder.php?orders_id=' . $orders_id);
    exit();

  }

// 到着確認通知送信
  if (!empty($_REQUEST['arrive'])) {

    $orders_id = $_REQUEST['arrive'];

    $sql = 'UPDATE orders SET progress = ? WHERE id = ?'; // SQL文を文字で用意
    $data = array(5,$_REQUEST['arrive']); // ?に入れるデータを配列で用意
    $stmt = $dbh->prepare($sql); // SQL文をデータベースにセット
    v($data);
    $stmt->execute($data); // SQL文を実行

    header('Location: matchingorder.php?orders_id=' . $orders_id);
    exit();

  }


  
if (!isset($_REQUEST['orders_id'])) {
  header('Location: mypage.php');
  exit();
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

      <div class="col-lg-4 col-lg-offset-4 centered">
        <h3>取引相手のプロフィール</h3>
        <hr>
      </div><!-- /col-lg-4 -->

      <div class="container"> 
        <div class="row mt centered ">
          <div class="col-xs-8 col-xs-offset-2">

            <?php if ($signin_user['id'] == $agent_id): ?>

              <div class="col-xs-4 centered">
                <img src="user_profile_img/<?php echo $client['img_name']; ?>" class="img-circle img-responsive img-thumbnail" width="140"><br>
                <?php echo $client['firstname']; ?>さん<br>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star-o"></span>
              </div>

              <div class="form-group">
                <div class="col-xs-8 pull-right">
                  <label>居住地</label>
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <?php echo $client['homecountry']; ?>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-8 pull-right">
                  <label>使用可能言語</label>
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <?php echo $client['language']; ?>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-8 pull-right">
                  <label>自己紹介</label>
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <?php echo $client['profile']; ?>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>

            <?php elseif($signin_user['id'] == $client_id): ?>

              <div class="col-xs-4 centered">
                <img src="user_profile_img/<?php echo $agent['img_name']; ?>" class="img-circle img-responsive img-thumbnail" width="140"><br>
                <?php echo $agent['firstname']; ?>さん<br>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star-o"></span>
              </div>

              <div class="form-group">
                <div class="col-xs-8 pull-right">
                  <label>居住地</label>
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <?php echo $agent['homecountry']; ?>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-8 pull-right">
                  <label>使用可能言語</label>
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <?php echo $agent['language']; ?>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-8 pull-right">
                  <label>自己紹介</label>
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <?php echo $agent['profile']; ?>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>


            <?php endif; ?>


          </div>
        </div>
      </div>

      <!-- -------------商品情報-------------------- -->

      <div class="row centered ">
        <div class="col-lg-4 col-lg-offset-4">
          <h3>商品情報</h3>
          <hr>
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->

      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <ul class="list-group" id="contact-list">
              <li class="list-group-item">
                <div class="col-xs-4">
                  <img src="order_images/<?php echo $order['images']; ?>" width="140">
                </div>

                <div class="col-xs-8">

                  <a href="offeragentlist.php?orders_id=<?php echo $order['id'] ?>"><span style="font-size: 24px;">
                    <?php if (!empty($order['item_name'])) { ?>
                    <?php echo $order['item_name'];?>
                    <?php } else { echo $order['title'];?>
                    <?php } ?>
                  </span></a><br>
                  個数<?php if (!empty($order['amount'])) { ?>
                  <?php echo $order['amount']; ?>個
                  <?php } elseif (!empty($order['file'])) { ?>
                  <?php echo $order['file']; ?>つ
                  <?php } elseif (!empty($order['draft'])) { ?>
                  <?php echo $order['draft'];?>枚
                  <?php } ?>
                  　依頼日時　<?php echo $order['created']; ?><br>

                  <div class="col-xs-4">
                    <ol>
                      <br>
                      <li><strong>価格</strong></li>
                      <li><strong>引渡日</strong></li>
                      <li><strong>引渡方法</strong></li>
                      <li><strong>コメント</strong></li>
                    </ol>
                  </div>

                  <div class="col-xs-8">
                    <ul>
                      <br>
                      <?php echo $offer['offer_price']; ?><br>
                      <?php echo $offer['delivery_deadline']; ?><br>
                      <?php echo $offer['delivery']; ?><br>
                      <?php echo $offer['comment']; ?><br>
                    </ul>
                  </div>

                </div>

                <div class="clearfix"></div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- -------------進捗状況-------------------- -->


      <div class="row mt centered ">
        <div class="col-lg-4 col-lg-offset-4">
          <h3>進捗状況</h3>
          <hr>
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->

      <?php if ($agent['id'] == $signin_user['id']): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
              <div class="col-xs-1">
                依頼完了
              </div>
              <div class="col-xs-1 col-xs-offset-2">
                準備
              </div>
              <div class="col-xs-1 col-xs-offset-2">
                購入
              </div>
              <div class="col-xs-1 col-xs-offset-2">
                発送
              </div>
              <div class="col-xs-1 col-xs-offset-1">
                到着
              </div>
            </div>
          </div>
        </div>
      <?php elseif($agent['id'] != $signin_user['id']): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
              <div class="col-xs-1">
                依頼完了
              </div>
              <div class="col-xs-1 col-xs-offset-2">
                準備
              </div>
              <div class="col-xs-1 col-xs-offset-2">
                購入
              </div>
              <div class="col-xs-1 col-xs-offset-2">
                発送
              </div>
              <div class="col-xs-1 col-xs-offset-1">
                到着
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- -------------進捗バー-------------------- -->

      <div class="container">
        <div class="row"><br />
          <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <div class="progress">
              <?php if ($order['progress'] == 1): ?>
                <div class="one no-color"></div><div class="two no-color"></div><div class="three no-color"></div>
                <div class="progress-bar" style="width: 28%;"></div>
              <?php elseif($order['progress'] == 2): ?>
                <div class="one primary-color"></div><div class="two no-color"></div><div class="three no-color"></div>
                <div class="progress-bar" style="width: 28%;"></div>
              <?php elseif($order['progress'] == 3): ?>
                <div class="one primary-color"></div><div class="two primary-color"></div><div class="three no-color"></div>
                <div class="progress-bar" style="width: 53%;"></div>
              <?php elseif($order['progress'] == 4): ?>
                <div class="one primary-color"></div><div class="two primary-color"></div><div class="three primary-color"></div>
                <div class="progress-bar" style="width: 78%;"></div>
              <?php elseif($order['progress'] == 5): ?>
                <div class="one primary-color"></div><div class="two primary-color"></div><div class="three primary-color"></div>
                <div class="progress-bar" style="width: 100%;"></div>
              <?php endif; ?>
            </div>
            <hr />
          </div>
        </div>
      </div>

      <!-- -------------購入通知ボタン-------------------- -->

      <?php if ($order['progress'] == 2 && $signin_user['id'] == $order['agent_id']): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <a href="matchingorder.php?buy=<?php echo $order['id'] ?>">
                <button class="btn btn-warning btn-block">購入通知
                </button>
              </a>
            </div>
          </div>
        </div>
      <?php endif ?>


      <!-- -------------取引相手が商品を準備しています-------------------- -->

      <?php if ($order['progress'] == 2 && $signin_user['id'] == $order['client_id']): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <button class="btn btn-info btn-block" disabled="disabled">エージェント商品準備中
              </button>
            </div>
          </div>
        </div>
      <?php endif ?>


      <!-- -------------発送通知ボタン-------------------- -->

      <?php if ($order['progress'] == 3 && $signin_user['id'] == $order['agent_id']): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <a href="matchingorder.php?ship=<?php echo $order['id'] ?>">
                <button class="btn btn-warning btn-block">発送完了通知
                </button>
              </a>
            </div>
          </div>
        </div>
      <?php endif ?>

      <!-- -------------取引相手が発送準備をしています-------------------- -->

      <?php if ($order['progress'] == 3 && $signin_user['id'] == $order['client_id']): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <button class="btn btn-info btn-block" disabled="disabled">エージェント発送準備中
              </button>
            </div>
          </div>
        </div>
      <?php endif ?>

      <!-- -------------到着連絡待ちボタン-------------------- -->

      <?php if ($order['progress'] == 4 && $signin_user['id'] == $order['agent_id']): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <button class="btn btn-info btn-block" disabled="disabled">到着連絡待ち
              </button>
            </div>
          </div>
        </div>
      <?php endif ?>

      <!-- -------------到着確認ボタン-------------------- -->

      <?php if ($order['progress'] == 4 && $signin_user['id'] == $order['client_id']): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <a href="matchingorder.php?arrive=<?php echo $order['id'] ?>">
                <button class="btn btn-warning btn-block">到着確認通知
                </button>
              </a>
            </div>
          </div>
        </div>
      <?php endif ?>

      <!-- -------------決済ページボタン-------------------- -->

      <?php if ($order['progress'] == 5 && $signin_user['id'] == $order['client_id'] && $order['flag'] == 2): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <a href="payment.php?orders_id=<?php echo $order['id'] ?>&offer_id=<?php echo $offer['id'] ?>">
                <button class="btn btn-warning btn-block">決済ページへ進む
                </button>
              </a>
            </div>
          </div>
        </div>
      <?php endif ?>


      <!-- -------------商品到着済み-------------------- -->

      <?php if ($order['progress'] == 5 && $signin_user['id'] == $order['agent_id'] && $order['flag'] == 2): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <button class="btn btn-info btn-block" disabled="disabled">商品確認済み
              </button>
            </div>
          </div>
        </div>
      <?php endif ?>


      <!-- -------------支払い済み-------------------- -->

      <?php if ($order['flag'] == 3): ?>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <button class="btn btn-success btn-block" disabled="disabled">支払い済み
              </button>
            </div>
          </div>
        </div>
      <?php endif ?>

      <!-- -------------メッセージ-------------------- -->

      <div class="container">
        <div class="row">
          <div class="row mt centered ">
            <div class="col-lg-4 col-lg-offset-4">
              <h3>メッセージ</h3>
              <hr>
            </div><!-- /col-lg-4 -->
          </div><!-- /row -->
        </div>
      </div>


      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2 scroll">
            <?php for($i=0;$i<$c;$i++){ ?>
            <?php if ($messages[$i]['sender'] == $signin_user['id']): ?>
              <div class="col-xs-12 col-sm-12">
                <div class="pull-right">
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <div class="col-xs-10">
                        <?php echo $signin_user['firstname']; ?><br>
                        <span style="font-size: 24px;"><?php echo $messages[$i]['message'] ?></span><br>
                        <?php echo $messages[$i]['created']; ?>
                      </div>
                      <div class="col-xs-2">
                        <img src="user_profile_img/<?php echo $signin_user['img_name']; ?>"  class="img-circle" width="40">
                      </div>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>
            <?php elseif($messages[$i]['sender'] == $agent['id']): ?>
              <div class="col-xs-12 col-sm-12">
                <div class="pull-left">
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <div class="col-xs-2">
                        <img src="user_profile_img/<?php echo $agent['img_name']; ?>"  class="img-circle" width="40">
                      </div>
                      <div class="col-xs-10">
                        <?php echo $agent['firstname']; ?><br>
                        <span style="font-size: 24px;"><?php echo $messages[$i]['message'] ?></span><br>
                        <?php echo $messages[$i]['created']; ?>
                      </div>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>
            <?php elseif($messages[$i]['sender'] == $client['id']): ?>
              <div class="col-xs-12 col-sm-12">
                <div class="pull-left">
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <div class="col-xs-2">
                        <img src="user_profile_img/<?php echo $client['img_name']; ?>"  class="img-circle" width="40">
                      </div>
                      <div class="col-xs-10">
                        <?php echo $client['firstname']; ?><br>
                        <span style="font-size: 24px;"><?php echo $messages[$i]['message'] ?></span><br>
                        <?php echo $messages[$i]['created']; ?>
                      </div>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>
            <?php endif; ?>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- -------------------メッセージフォーム----------------------------- -->

      <div class="row">
      <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 centered">
        <!-- フィードと投稿フォーム -->
        <form method="POST" action="matchingorder.php">
          <textarea class="form-control" name="feed"></textarea>
          <?php if(isset($errors['feed']) && $errors['feed'] == 'blank'){?>
          <p class="text-danger">投稿データを入力してください</p>
          <?php } ?><br>
          <input type="hidden" name="orders_id" value="<?php echo $_REQUEST['orders_id']; ?>">
          <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
          <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>">
          <input type="submit" value="投稿" class="btn btn-wa">
        </form>
      </div>
    </div>


    </div><!-- /container -->
  <br>


<?php require('footer.php'); ?>

    </body>
    </html>

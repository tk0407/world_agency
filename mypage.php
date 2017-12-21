    <?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    require('signin_check.php');
    // v($_SESSION['signin_user']['id']);
    // $_SESSION['signin_user']['id']=1;

        // メッセージ取得
    $sql = 'SELECT * FROM messages WHERE receiver = ? ORDER BY created DESC';
    $data = array($signin_user['id']);
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
    // v($messages);


    // メッセージが3件以上ある場合は、3件だけ取得、2件以下の場合はメッセージの数だけ取得（メッセージ送信者のユーザー情報を取得）
    if ($c>=3) {

        $senders = array();
        for($i=0;$i<3;$i++){
              // sender取得
          $sql = 'SELECT * FROM users WHERE id = ?';
          $data = array($messages[$i]['sender']);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);

          $sender = $stmt->fetch(PDO::FETCH_ASSOC);
          $senders[] = $sender;
        }
    }elseif ($c<=2) {
        $senders = array();
        for($i=0;$i<$c;$i++){
              // sender取得
          $sql = 'SELECT * FROM users WHERE id = ?';
          $data = array($messages[$i]['sender']);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);

          $sender = $stmt->fetch(PDO::FETCH_ASSOC);
          $senders[] = $sender;
        }
    }


        // オーダー情報取得
    $sql = 'SELECT * FROM orders WHERE client_id = ? OR agent_id = ? ORDER BY updated DESC';
    $data = array($signin_user['id'],$signin_user['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $orders = array();
    while(true){
      $order = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($order == false) {
        break;
      }
      $orders[] = $order;
    }
    $o = count($orders);



    // クライアント側フィード取得
    $sql = 'SELECT * FROM orders WHERE client_id = ? ORDER BY updated DESC';
    $data = array($signin_user['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $client = array();
    while(true){
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($record == false) {
        break;
      }
      $client[] = $record;
    }
    $cc = count($client);


        // エージェント側フィード取得
    $sql = 'SELECT * FROM offers LEFT JOIN orders ON orders.id = offers.order_id WHERE offers.agent_id = ?';
    $data = array($signin_user['id']);
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


            // offers情報取得
    $sql = 'SELECT * FROM offers LEFT JOIN orders ON orders.id = offers.order_id WHERE orders.client_id = ?';
    $data = array($signin_user['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $offer = array();
    while(true){
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($record == false) {
        break;
      }
      $offer[] = $record;
    }
    $co = count($offer);

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

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" /> -->

  </head>

  <body style="margin-top: ; background: #FFFFFF;">
    <?php require('navbar.php'); ?>

    <div class="container">
      <div class="row mu centered ">
        <div class="col-lg-4 col-lg-offset-4">
          <h3>マイページ</h3>
          <hr>
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->
    </div>

    <div class="container">
      <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
         <div class="profile">
          <div class="col-sm-12">
            <div class="col-xs-12 col-sm-12 text-center">
              <figure>
                <img src="user_profile_img/<?php echo htmlspecialchars($signin_user['img_name']); ?>" alt="" class="img-circle img-responsive img-thumbnail" width="180">
              </figure>
            </div>
            <div class="col-xs-12 col-sm-12 text-center">
              <figure>
                <figcaption class="ratings">
                  <p><strong><?php echo htmlspecialchars($signin_user['firstname']); ?>さん</strong>  </p>
                  <p>Ratings
                    <a href="#">
                      <span class="fa fa-star "></span>
                    </a>
                    <a href="#">
                      <span class="fa fa-star"></span>
                    </a>
                    <a href="#">
                      <span class="fa fa-star"></span>
                    </a>
                    <a href="#">
                      <span class="fa fa-star"></span>
                    </a>
                    <a href="#">
                     <span class="fa fa-star-o"></span>
                   </a>
                 </p>
               </figcaption>
             </figure>
           </div>
         </div>            
         <div class="col-xs-12 divider text-center">
          <div class="col-xs-4 col-sm-4 emphasis">
            <a class="btn btn-wa btn-block" href="orderstatus.php?user_id=<?php echo $signin_user['id']; ?>" class="text-primary">取引一覧</a>
          </div>
          <div class="col-xs-4 col-sm-4 emphasis">
            <a class="btn btn-wa btn-block" href="register/edit_profile.php?id=<?php echo $signin_user['id']; ?>" class="text-primary">プロフィール編集 </a>
          </div>
          <div class="col-xs-4 col-sm-4 emphasis">
            <button class="btn btn-wa btn-block">お気に入り </button>
          </div>

          <div class="col-xs-4 col-sm-4 emphasis">
            <button class="btn btn-wa btn-block"> 評価 </button>
          </div>
          <div class="col-xs-4 col-sm-4 emphasis">
            <button class="btn btn-wa btn-block">フォロー </button>
          </div>
          <div class="col-xs-4 col-sm-4 emphasis">
            <button class="btn btn-wa btn-block">フォロワー </button>
          </div>

        </div>
      </div>                 
    </div>
  </div>
</div>
</body>


<! ========== BLOG POSTS ==================================================================================================== 
=============================================================================================================================>    
<div id="white">
	<div class="container">	
		<div class="row mu centered ">
			<div class="col-lg-4 col-lg-offset-4">
				<h3>新着メッセージ</h3>
				<hr>
      </div><!-- /col-lg-4 -->
    </div><!-- /row -->

    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
          <!-- タイムライン -->
          <?php if ($c>=3): ?>
            
              <?php for($i=0;$i<3;$i++){ ?>
              <div class="thumbnail">
                <div class="row">
                  <div class="col-xs-3 centered">
                    <img src="user_profile_img/<?php echo $senders[$i]['img_name']; ?>" class="img-circle img-responsive img-thumbnail" width="60">
                  </div>
                  <div class="col-xs-6">
                    <a href="matchingorder.php?orders_id=<?php echo $messages[$i]['order_id'] ?>"><span style="font-size: 24px;"><?php echo $messages[$i]['message'] ?></span></a><br>
                    <?php echo $messages[$i]['created']; ?>
                  </div>
                  <div class="col-xs-3">
                    <a href="matchingorder.php?orders_id=<?php echo $messages[$i]['order_id'] ?>">
                      <button class="btn btn-wa btn-block">確認</button>
                    </a>
                  </div>
                </div>
              </div>
              <?php } ?>

          <?php elseif($c<=2): ?>

              <?php for($i=0;$i<$c;$i++){ ?>
              <div class="thumbnail">
                <div class="row">
                  <div class="col-xs-3 centered">
                    <img src="user_profile_img/<?php echo $senders[$i]['img_name']; ?>" class="img-circle img-responsive img-thumbnail" width="60">
                  </div>
                  <div class="col-xs-6">
                    <a href="matchingorder.php?orders_id=<?php echo $messages[$i]['order_id'] ?>"><span style="font-size: 24px;"><?php echo $messages[$i]['message'] ?></span></a><br>
                    <?php echo $messages[$i]['created']; ?>
                  </div>
                  <div class="col-xs-3">
                    <a href="matchingorder.php?orders_id=<?php echo $messages[$i]['order_id'] ?>">
                      <button class="btn btn-wa btn-block">確認</button>
                    </a>
                  </div>
                </div>
              </div>
              <?php } ?>

          <?php endif; ?>
        </div>
      </div>
    </div>

  </div><!-- /container -->
</div><!-- /black -->

<! ========== BLACK SECTION ================================================================================================= 
=============================================================================================================================>    
<div id="black">
  <div class="container">
    <div class="row mu centered">
      <div class="col-lg-4 col-lg-offset-4">
        <h3>新着取引</h3>
        <hr>
      </div><!-- /col-lg-4 -->
    </div><!-- /row -->

    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">

<!-- ------------------クライアント側------------------------- -->

          <!-- タイムライン -->
          <?php if ($cc>=3): ?>
            
              <?php for($i=0;$i<3;$i++){ ?>
              <div class="thumbnail">
                <div class="row">
                  <div class="col-xs-3 centered">
                    <img src="order_images/<?php echo $client[$i]['images']; ?>" width="60">
                  </div>
                  <div class="col-xs-6">
                    <a href=""><span style="font-size: 24px;">
                    <?php if (!empty($client[$i]['item_name'])) { ?>
                    <?php echo $client[$i]['item_name'];?>
                    <?php } else { echo $client[$i]['title'];?>
                    <?php } ?>
                    </span></a><br>
                    個数<?php if (!empty($client[$i]['amount'])) { ?>
                        <?php echo $client[$i]['amount']; ?>個
                    <?php } elseif (!empty($client[$i]['file'])) { ?>
                        <?php echo $client[$i]['file']; ?>つ
                    <?php } elseif (!empty($client[$i]['draft'])) { ?>
                        <?php echo $client[$i]['draft'];?>枚
                    <?php } ?>
                    　依頼日時　<?php echo $client[$i]['created']; ?>
                  </div>
                  <div class="col-xs-3 centered">
                    <?php if ($client[$i]['flag'] == 0): ?>
                      <a href="offeragentlist.php?orders_id=<?php echo $client[$i]['id'] ?>">
                        <button class="btn btn-info btn-block">オファー受付中</button>
                      </a>
                    <?php elseif($client[$i]['flag'] == 1): ?>
                      <a href="offeragentlist.php?orders_id=<?php echo $client[$i]['id'] ?>">
                        <button class="btn btn-info btn-block">オファー受付中</button>
                      </a>
                        <i class="fa fa-hand-paper-o faa-flash animated" aria-hidden="true"></i>オファーあり
                    <?php elseif($client[$i]['flag'] == 2): ?>
                      <a href="matchingorder.php?orders_id=<?php echo $client[$i]['id'] ?>">
                        <button class="btn btn-danger btn-block">取引中</button>
                      </a>
                    <?php elseif($client[$i]['flag'] == 3): ?>
                      <a href="matchingorder.php?orders_id=<?php echo $client[$i]['id'] ?>">
                        <button class="btn btn-success btn-block">取引完了</button>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <?php } ?>

          <?php elseif($cc<=2): ?>

              <?php for($i=0;$i<$cc;$i++){ ?>
              <div class="thumbnail">
                <div class="row">
                  <div class="col-xs-3 centered">
                    <img src="order_images/<?php echo $client[$i]['images']; ?>" width="60">
                  </div>
                  <div class="col-xs-6">
                    <a href=""><span style="font-size: 24px;">
                    <?php if (!empty($client[$i]['item_name'])) { ?>
                    <?php echo $client[$i]['item_name'];?>
                    <?php } else { echo $client[$i]['title'];?>
                    <?php } ?>
                    </span></a><br>
                    個数<?php if (!empty($client[$i]['amount'])) { ?>
                        <?php echo $client[$i]['amount']; ?>個
                    <?php } elseif (!empty($client[$i]['file'])) { ?>
                        <?php echo $client[$i]['file']; ?>つ
                    <?php } elseif (!empty($client[$i]['draft'])) { ?>
                        <?php echo $client[$i]['draft'];?>枚
                    <?php } ?>
                    　依頼日時　<?php echo $client[$i]['created']; ?>
                  </div>
                  <div class="col-xs-3 centered">
                    <?php if ($client[$i]['flag'] == 0): ?>
                      <a href="offeragentlist.php?orders_id=<?php echo $client[$i]['id'] ?>">
                        <button class="btn btn-info btn-block">オファー受付中</button>
                      </a>
                    <?php elseif($client[$i]['flag'] == 1): ?>
                      <a href="offeragentlist.php?orders_id=<?php echo $client[$i]['id'] ?>">
                        <button class="btn btn-info btn-block">オファー受付中</button>
                      </a>
                        <i class="fa fa-hand-paper-o faa-flash animated" aria-hidden="true"></i>オファーあり
                    <?php elseif($client[$i]['flag'] == 2): ?>
                      <a href="matchingorder.php?orders_id=<?php echo $client[$i]['id'] ?>">
                        <button class="btn btn-danger btn-block">取引中</button>
                      </a>
                    <?php elseif($client[$i]['flag'] == 3): ?>
                      <a href="matchingorder.php?orders_id=<?php echo $client[$i]['id'] ?>">
                        <button class="btn btn-success btn-block">取引完了</button>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <?php } ?>


          <?php endif; ?>

<!-- ------------------エージェント側------------------------- -->

          <?php if ($ca>=3): ?>
            
            <?php for($i=0;$i<$ca;$i++){ ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-3 centered">
                <img src="order_images/<?php echo $agent[$i]['images']; ?>" width="60"><i class="fa fa-hand-paper-o faa-flash animated" aria-hidden="true"></i>
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
                <?php if ($agent[$i]['flag'] == 1): ?>
                  <a href="waitingoffer.php?offer_id=<?php echo $agent[$i]['order_id'] ?>">
                    <button class="btn btn-info btn-block">オファー未承認</button>
                  </a>
                <?php elseif($agent[$i]['flag'] == 2 && $agent[$i]['agent_id'] != $signin_user['id']): ?>
                  <button class="btn btn-secondary btn-block">不成立</button>
                <?php elseif($agent[$i]['flag'] == 2 && $agent[$i]['agent_id'] == $signin_user['id']): ?>
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

          <?php elseif($ca<=2): ?>

              <?php for($i=0;$i<$ca;$i++){ ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-3 centered">
                <img src="order_images/<?php echo $agent[$i]['images']; ?>" width="60">
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
                <?php if ($agent[$i]['flag'] == 1): ?>
                  <a href="waitingoffer.php?offer_id=<?php echo $agent[$i]['order_id'] ?>">
                    <button class="btn btn-info btn-block">オファー未承認</button>
                  </a>
                <?php elseif($agent[$i]['flag'] == 2 && $agent[$i]['agent_id'] != $signin_user['id']): ?>
                  <button class="btn btn-secondary btn-block">不成立</button>
                <?php elseif($agent[$i]['flag'] == 2 && $agent[$i]['agent_id'] == $signin_user['id']): ?>
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

          <?php endif; ?>
        </div>
      </div>
    </div>
    <br>

  </div><!-- /container -->
</div><!-- /black -->

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

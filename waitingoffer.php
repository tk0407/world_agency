<?php
session_start();
require('dbconnect.php');
require('functions.php');
require('signin_check.php');

if (!isset($_REQUEST['offer_id'])) {
  header('Location: mypage.php');
  exit();
}

if (isset($_REQUEST['offer_id'])) {
  $offer_id = $_REQUEST['offer_id'];

    // オファー情報取得
  $sql = 'SELECT * FROM offers WHERE id = ?';
  $data = array($offer_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $offer = $stmt->fetch(PDO::FETCH_ASSOC);

  $order_id = $offer['order_id'];

    // オーダー情報取得
  $sql = 'SELECT * FROM orders WHERE id = ?';
  $data = array($order_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $order = $stmt->fetch(PDO::FETCH_ASSOC);

  $client_id = $order['client_id'];

    // クライアント情報取得
  $sql = 'SELECT * FROM users WHERE id = ?';
  $data = array($client_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $client = $stmt->fetch(PDO::FETCH_ASSOC);


}

if ($offer['agent_id'] != $signin_user['id']) {
  echo '不正なアクセスです';
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
    <div class="container"> 
      <div class="row mt centered ">
        <div class="col-lg-4 col-lg-offset-4">
          <h3>送信済みオファー確認</h3>
          <hr>
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->



      <div class="container">
        <div class="row">

          <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <ul class="list-group" id="contact-list">
              <li class="list-group-item">
                <div class="col-xs-12">
                  <strong>クライアント側希望条件</strong>
                </div>

                <div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="col-xs-5 centered">
                        <img src="order_images/<?php echo $order['images'];?>" class="img-responsive img-thumbnail" width="300">
                      </div>
                      <div class="col-xs-5">
                        <div>
                          <?php if (!empty($order['country'])) { ?>
                          <span>国</span>
                          <p class="lead">
                            <?php echo $order['country'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <!-- TODO:商品名フォント小さい？修正 -->
                          <span>商品名</span><br>
                          <?php if (!empty($order['item_name'])) { ?>
                          <p class="lead">
                            <?php echo $order['item_name'];?>
                          </p>
                          <p class="lead">
                            <?php } else { echo $order['title'];?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <span>個数</span>
                          <?php if (!empty($order['amount'])) { ?>
                          <p class="lead">
                            <?php echo $order['amount']; ?><span>個</span>
                          </p>
                          <?php } elseif (!empty($order['file'])) { ?>
                          <p class="lead">
                            <?php echo $order['file']; ?><span>つ</span>
                          </p>
                          <?php } elseif (!empty($order['draft'])) { ?>
                          <p class="lead">
                            <?php echo $order['draft'];?><span>枚</span>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <?php if (!empty($order['order_price'])) { ?>
                          <span>希望価格</span>
                          <p class="lead">
                            <?php echo $order['order_price'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <?php if (!empty($order['delivery_date'])) { ?>
                          <span>希望受取日</span>
                          <p class="lead">
                            <?php echo $order['delivery_date'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <?php if (!empty($order['publication_period'])) { ?>
                          <span>掲載期間</span>
                          <p class="lead">
                            <?php echo $order['publication_period'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <?php if (!empty($order['recruitment_numbers'])) { ?>
                          <span>募集人数</span>
                          <p class="lead">
                            <?php echo $order['recruitment_numbers'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <?php if (!empty($order['requirement_skills'])) { ?>
                          <span>求めるスキル</span>
                          <p class="lead">
                            <?php echo $order['requirement_skills'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <?php if (!empty($order['detail'])) { ?>
                          <span>詳細</span>
                          <p class="lead">
                            <?php echo $order['detail'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <?php if (!empty($order['request'])) { ?>
                          <span>提案条件</span>
                          <p class="lead">
                            <?php echo $order['request'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <div>
                          <?php if (!empty($order['purpose'])) { ?>
                          <span>利用目的</span>
                          <p class="lead">
                            <?php echo $order['purpose'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                        <!-- ↓もし,$imagesが空じゃなかったら発動する、空だったらスルーの処理を行う -->
                        <div>
                          <?php if (!empty($order['attached_file'])) { ?>
                          <span>添付ファイル</span>
                          <p class="lead">
                            <?php echo $order['attached_file'] ;?>
                            <?php } else { echo ""; ?>
                          </p>
                          <?php } ?>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>


                <div class="col-xs-12">
                  <strong>自分が提示した条件</strong>
                </div>

                <div class="col-xs-12">
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                     <div class="col-xs-3 col-xs-offset-1">
                      <ol>
                        <li><strong>価格</strong></li>
                        <li><strong>引渡日</strong></li>
                        <li><strong>引渡方法</strong></li>
                        <li><strong>コメント</strong></li>
                      </ol>

                    </div>

                    <div class="col-xs-8">
                      <ul>
                        <?php echo $offer['offer_price']; ?> 円<br>
                        <?php echo $offer['delivery_deadline']; ?><br>
                        <?php echo $offer['delivery']; ?><br>
                        <?php echo $offer['comment']; ?><br>
                      </ul>
                    </div>
                    <div class="clearfix"></div>
                  </li>
                </ul>
              </div><br>

              <div class="col-xs-12">
                <strong>クライアントプロフィール</strong>
              </div>

              <div class="col-xs-12 col-sm-8 col-sm-offset-2 centered">
                <img src="user_profile_img/<?php echo $client['img_name']; ?>" class="img-circle img-responsive img-thumbnail" width="140"><br>
                <?php echo $client['firstname']; ?>さん<br>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star"></span>

                <span class="fa fa-star-o"></span>
              </div>

              <div class="form-group">
                <div class="col-xs-12">
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
                <div class="col-xs-12">
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
                <div class="col-xs-12">
                  <label>自己紹介</label>
                  <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                      <?php echo $client['profile']; ?>
                      <div class="clearfix"></div>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="col-xs-12 col-sm-4 centered">
                <a href="orderstatus.php?user_id=<?php echo $signin_user['id']; ?>" class="btn btn-wa">戻る</a>
              </div>

              <div class="clearfix"></div>

            </li>
          </ul>
        </div>
      </div>
    </div>


  </div><!-- /container -->
</div><!-- /black -->

<?php require('footer.php'); ?>

    </body>
    </html>

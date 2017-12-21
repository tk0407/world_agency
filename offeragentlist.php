　<?php
session_start();
require('dbconnect.php');
require('functions.php');
require('signin_check.php');

if (!isset($_REQUEST['orders_id'])) {
  header('Location: users.php');
  exit();
}

$orders_id = $_REQUEST['orders_id'];

    // ユーザー情報取得
$sql = 'SELECT * FROM offers LEFT JOIN users ON offers.agent_id = users.id WHERE offers.order_id = ? ORDER BY offers.updated DESC';
$data = array($orders_id);
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

    // オーダー情報取得
$sql = 'SELECT * FROM orders WHERE id = ?';
$data = array($orders_id);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$order = $stmt->fetch(PDO::FETCH_ASSOC);


if ($order['client_id'] != $signin_user['id']) {
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

        <br>
        <br>
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <h2 class="text-center content_header">依頼内容</h2>
              <hr>
              <div class="row">
                <div class="col-xs-6 centered">
                  <img src="order_images/<?php echo $order['images'];?>" class="img-responsive img-thumbnail" width="300">
                </div>
                <div class="col-xs-6">
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
    </div>
  </div>


  <!-- -------------Category1編集ボタン flag0-------------------- -->
<!-- 
  <?php if ($order['flag'] == 0 && $order['category'] == 1): ?>
    <div class="container">
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 centered">
          <a href="ordercheck1.php?edit=<?php echo $order['id'] ?>">
            <button class="btn btn-wa">依頼を修正する
            </button>
          </a>
        </div>
      </div>
    </div>
  <?php endif ?> -->

  <!-- -------------Category2編集ボタン 情報-------------------- -->

<!--   <?php if ($order['flag'] == 0 && $order['category'] == 2): ?>
    <div class="container">
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 centered">
          <a href="ordercheck2.php?edit=<?php echo $order['id'] ?>">
            <button class="btn btn-wa">依頼を修正する
            </button>
          </a>
        </div>
      </div>
    </div>
  <?php endif ?> -->


  <!-- -------------Category3編集ボタン-------------------- -->

<!--   <?php if ($order['flag'] == 0 && $order['category'] == 3): ?>
    <div class="container">
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 centered">
          <a href="ordercheck3.php?edit=<?php echo $order['id'] ?>">
            <button class="btn btn-wa">依頼を修正する
            </button>
          </a>
        </div>
      </div>
    </div>
  <?php endif ?> -->



  <!-- -------------依頼削除ボタン flag0-------------------- -->

  <?php if ($order['flag'] == 0 || $order['flag'] == 1 && $order['client_id'] == $signin_user['id']): ?>
    <div class="container">
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 centered">
          <br>
          <a href="delete.php?delete_id=<?php echo $order['id'] ?>" class="btn btn-danger" onClick="javascript:return confirm('本当に削除しますか？')">依頼を削除する
          </a>
        </div>
      </div>
    </div>
  <?php endif ?>


<!-- -----------------------エージェント一覧 -------------------------------- -->

<?php if ($c >= 1): ?>
  


  <div class="row mt centered ">
    <div class="col-lg-4 col-lg-offset-4">
      <h2 class="text-center content_header">エージェント一覧</h2>
      <hr>
    </div><!-- /col-lg-4 -->
  </div><!-- /row -->


  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="col-xs-2">
          <span class="name text-primary"></span><br/>
        </div>
        <div class="col-xs-4">
          <span class="name">　コメント</span><br/>
        </div>
        <div class="col-xs-2">
          <span class="name">価格</span><br/>
        </div>
        <div class="col-xs-2">
          <span class="name">期限</span><br/>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>

  <?php for($i=0;$i<$c;$i++){ ?>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <ul class="list-group" id="contact-list">
          <li class="list-group-item">
              <div class="col-xs-2">
                <img src="user_profile_img/<?php echo $orders[$i]['img_name']; ?>" width="80">

              </div>
              <div class="col-xs-4">
                <span class="name text-primary"><?php echo $orders[$i]['firstname']; ?> さん</span><br/>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star-o"></span>
               <br><?php echo $orders[$i]['comment']; ?>
             </div>
             <div class="col-xs-2">
              <span class="name text-primary"><?php echo $orders[$i]['offer_price']; ?></span><br/>
            </div>
            <div class="col-xs-2 centered">
              <span class="name text-primary"><?php echo $orders[$i]['delivery_deadline']; ?></span><br/>
            </div>
            <div class="col-xs-2">
              <a href="agentdetail.php?agent_id=<?php echo $orders[$i]['id'] ?>&order_id=<?php echo $orders[$i]['order_id'] ?>">
                <button class="btn btn-info btn-block">確認</button>
              </a>
            </div>
            <div class="clearfix"></div>
        </div>
      </div>
      <?php } ?>


    </div><!-- /container -->
  </div><!-- /black -->

<?php elseif($c == 0): ?>

    <div class="row mt centered ">
    <div class="col-lg-4 col-lg-offset-4">
      <h2 class="text-center content_header">エージェント一覧</h2>
      <hr>
      <br>
      <h4>エージェントからのオファーがありません</h4>
    </div><!-- /col-lg-4 -->
  </div><!-- /row -->


<?php endif; ?>




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

      <script type="text/javascript">
      function submitbtn() {
          // 「OK」ボタン押下時
          if (confirm('依頼を削除してもよろしいですか？')) {
              alert('削除');
          }
          // 「キャンセル」ボタン押下時
          else {
              alert('キャンセル');
          }
      }
      </script>

    </body>
    </html>

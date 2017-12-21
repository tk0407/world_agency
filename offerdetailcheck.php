<?php
    session_start();
    // requireでfunctionsの関数を呼び出す。linkのようなモノ
    require('dbconnect.php');
    require('functions.php');
    require('signin_check.php');

    // $signin_user['id'] = 1; //後でsignin idをここに表示できるようにする。

    if(!isset($_SESSION['register'])) {
      header('Location: offerdetail.php');
      exit();
    }
    $order_id = $_REQUEST['orders_id'];
    // v($order_id);

    $city = '';

    if (!empty($order_id)) {
      $sql = 'SELECT * FROM `orders` WHERE id = ?';
      $data = array($order_id);
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(1, $id, PDO::PARAM_INT);
      $stmt->execute($data);
      $order = $stmt->fetch(PDO::FETCH_ASSOC);

      $sql = 'SELECT * FROM `cities` WHERE id = ?';
      $data = array($order['city_id']);
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(1, $city, PDO::PARAM_INT); //インジェクション対策
      $stmt->execute($data);
      $city = $stmt->fetch(PDO::FETCH_ASSOC);

      // 依頼を上げたクライアントのidを選択
      $sql = 'SELECT * FROM `users` WHERE id = ?';
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(1, $order['client_id'], PDO::PARAM_INT); //インジェクション対策
      $stmt->execute();
      $client = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      // header('Location: orderlist.php');
      // exit();
      }
      // v($order);

    // v($_POST);
    // v($_SESSION['signin_user']['id']);

    // v($_SESSION['register']);

    // $country = $_SESSION['register']['country'];
    // $city_id = $_SESSION['register']['city'];
    $offer_price = $_SESSION['register']['offer_price'];
    $delivery_deadline = $_SESSION['register']['delivery_deadline'];
    $delivery = $_SESSION['register']['delivery'];
    $comment = $_SESSION['register']['comment'];
    $agent_id = $_SESSION['signin_user']['id'];
    $order_id = $order['id'];


    // 登録ボタンが押された時の処理
    if (!empty($_POST)) {
        echo '通過<br>';
        // $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO `offers` SET
          `offer_price`=?
          ,`delivery_deadline`=?
          ,`delivery`=?
          ,`comment`=?
          ,`agent_id`=?
          ,`order_id`=?
          ';
          // 上記が雛形の書き方
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $offer_price, PDO::PARAM_INT);
        $stmt->bindParam(2, $delivery_deadline, PDO::PARAM_STR);
        $stmt->bindParam(3, $delivery, PDO::PARAM_STR);
        $stmt->bindParam(4, $comment, PDO::PARAM_STR);
        $stmt->bindParam(5, $agent_id, PDO::PARAM_STR);
        $stmt->bindParam(6, $order_id, PDO::PARAM_STR);
        $stmt->execute();

        $sql = 'UPDATE `orders` SET `flag`=1 WHERE `id` =?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $order_id, PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['register']);
        header('Location: thanksoffer.php');
        exit();

    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>World Agency</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <!-- 基本bootの下でfont awesome読み込む -->
  <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0/css/font-awesome.css">
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
  <!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
  
  
  <!-- JavaScripts needed at the beginning
  ================================================== -->
  <script type="text/javascript" src="http://alvarez.is/demo/marco/assets/js/twitterFetcher_v10_min.js"></script>

  <!-- MAP SCRIPT - ALL CONFIGURATION IS PLACED HERE - VIEW OUR DOCUMENTATION FOR FURTHER INFORMATION -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
  <script type="text/javascript">
      // When the window has finished loading create our google map below
      google.maps.event.addDomListener(window, 'load', init);
  
      function init() {
          // Basic options for a simple Google Map
          // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
          var mapOptions = {
              // How zoomed in you want the map to start at (always required)
              zoom: 11,
              
              scrollwheel: false,

              // The latitude and longitude to center the map (always required)
              center: new google.maps.LatLng(40.6700, -73.9400), // New York

              // How you would like to style the map. 
              // This is where you would paste any style found on Snazzy Maps.
              styles: [ {   featureType:'water',    stylers:[{color:'#74c9be'},{visibility:'on'}] },{   featureType:'landscape',    stylers:[{color:'#f2f2f2'}] },{   featureType:'road',   stylers:[{saturation:-100},{lightness:45}]  },{   featureType:'road.highway',   stylers:[{visibility:'simplified'}] },{   featureType:'road.arterial',    elementType:'labels.icon',    stylers:[{visibility:'off'}]  },{   featureType:'administrative',   elementType:'labels.text.fill',   stylers:[{color:'#444444'}] },{   featureType:'transit',    stylers:[{visibility:'off'}]  },{   featureType:'poi',    stylers:[{visibility:'off'}]  }]
          };

          // Get the HTML DOM element that will contain your map 
          // We are using a div with id="map" seen below in the <body>
          var mapElement = document.getElementById('map');

          // Create the Google Map using out element and options defined above
          var map = new google.maps.Map(mapElement, mapOptions);
      }
  </script>
  
  
  <!-- Main Jquery & Hover Effects. Should load first -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="assets/js/hover_pack.js"></script>
  

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<body style="margin-top: 50px; background:white;">
  <?php require('navbar.php'); ?>

  <div class="container" style="opacity: 0.9;">
    <div class="row">
      <!-- ここから -->
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-left content_header">依頼詳細</h2>
        <form method="POST" action="" enctype="multipart/form-data">
          <!-- ユーザー情報表示 -->
          <div class="row">
              <div class="col-lg-5" style="margin:30px auto">
                  <div class="media">
                      <a class="pull-left" href="#">
                          <img class="media-object dp img-circle" src="user_profile_img/<?php echo htmlspecialchars($client['img_name']); ?>" style="width: 100px;height:100px;">
                      </a>
                      <div class="media-body">
                          <h4 class="media-heading"><?php echo $client['firstname'], $client['lastname'];?> <small> <?php echo $client['homecountry'];?></small></h4>
                          <h5><?php echo $client['evaluate_id'];?></h5>
                          <hr style="margin:8px auto">

                          <span class="label label-default"><?php echo $client['language'];?></span>
                          <span class="label label-default"></span>
                          <span class="label label-info"></span>
                          <span class="label label-default"></span>
                      </div>
                  </div>
              </div>
          </div>
          <!-- 依頼内容表示 -->
        <div class="container" style="padding-right: 95px; padding-left: 50px">
          <div class="row">
            <div class="col-xs-8  thumbnail">
              <h2 class="text-center content_header">依頼内容</h2>
              <div class="row">
                <div class="col-xs-5">
                  <img src="order_images/<?php echo $order['images'];?>" class="img-responsive img-thumbnail">
                  <p>お気に入り - <i class="fa fa-heart-o"></i></p>
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
                    <span>都市</span>
                    <p class="lead"><?php echo $city['city_name'];?></p>
                  </div>
                  <div>
                    <?php if (!empty($order['item_name'])) { ?>
                    <span>商品名</span>
                      <p class="lead">
                        <?php echo $order['item_name'];?>
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
        <!-- 前ページで入力した内容を表示 -->
        <div class="col-xs-8">
          <div>
            <span>引受け価格</span>
            <p class="lead"><?php echo $offer_price;?></p>
          </div>
          <div>
            <span>引渡期限</span>
            <p class="lead"><?php echo $delivery_deadline;?></p>
          </div>
          <div>
            <span>引渡方法</span>
            <p class="lead"><?php echo $delivery;?></p>
          </div>
          <div>
            <span>コメント</span>
            <p class="lead"><?php echo $comment;?></p>
          </div>
          <!-- ③ -->
          <form method="POST" action="offerdetailcheck.php">
            <!-- ④ -->
            <a href="offerdetail.php?orders_id=<?php echo $order_id ?>" class="btn btn-default">&laquo;&nbsp;戻る</a> |
            <!-- ⑤ -->
            <input type="hidden" name="action" value="submit">
            <input type="submit" class="btn btn-primary" value="この内容で依頼を引き受ける">
          </form>
        </div>
      </form>
    </div>
  </div>
  <! ========== FOOTER ======================================================================================================== 
  =============================================================================================================================>    
  </div>

  <div id="f">
      <div class="container">
        <div class="row">
          <!-- ADDRESS -->
          <div class="col-lg-3">
            <h4>Our Studio</h4>
            <p>
              Some Ave. 987,<br/>
              Postal 64733<br/>
              London, UK.<br/>
            </p>
            <p>
              <i class="fa fa-mobile"></i> +55 4893.8943<br/>
              <i class="fa fa-envelope-o"></i> hello@yourdomain.com
            </p>
          </div><! --/col-lg-3 -->
          
          <!-- TWEETS -->
          <div class="col-lg-3">
            <h4>Recent Tweets</h4>
            <div id="showtweets"></div>
              <script>
                twitterFetcher.fetch('258157205101088768', 'showtweets', 2, true, false, false, '', false, handleTweets, false);
                
                function handleTweets(tweets){
                    var x = tweets.length;
                    var n = 0;
                    var element = document.getElementById('showtweets');
                    var html = '<ul>';
                    while(n < x) {
                      html += '<li>' + tweets[n] + '</li>';
                      n++;
                    }
                    html += '</ul>';
                    element.innerHTML = html;
                }         
              </script>
            <p>Follow us <b>@Alvrz_is</b></p>
          </div><!-- /col-lg-3 -->
          
          <!-- LATEST POSTS -->
          <div class="col-lg-3">
            <h4>Latest Posts</h4>
            <p>
              <i class="fa fa-angle-right"></i> A post with an image<br/>
              <i class="fa fa-angle-right"></i> Other post with a video<br/>
              <i class="fa fa-angle-right"></i> A full width post<br/>
              <i class="fa fa-angle-right"></i> We talk about something nice<br/>
              <i class="fa fa-angle-right"></i> Yet another single post<br/>
            </p>
          </div><!-- /col-lg-3 -->
          
          <!-- NEW PROJECT -->
          <div class="col-lg-3">
            <h4>New Project</h4>
            <a href="#"><img class="img-responsive" src="assets/img/portfolio/port03.jpg" alt="" /></a>
          </div><!-- /col-lg-3 -->
          
          
        </div><! --/row -->
      </div><!-- /container -->
    </div><!-- /f -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script type="assets/js/jquery.js"></script>
    <script type="assets/js/bootstrap.js"></script>
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
</body>
</html>
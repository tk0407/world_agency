<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    // require('signin_check.php');ログインしていないとこのページに来れない

    $order_id = $_REQUEST['orders_id'];
      // v($order_id);
    $city_id = '';
    $city = '';

    if (!empty($order_id)) {
      $sql = 'SELECT * FROM `orders` WHERE id = ?';
      $data = array($order_id);
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(1, $id, PDO::PARAM_INT); //インジェクション対策
      $stmt->execute($data);
      $order = $stmt->fetch(PDO::FETCH_ASSOC);

      $sql = 'SELECT * FROM `cities` WHERE id = ?';
      $data = array($order['city_id']);
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(1, $city, PDO::PARAM_INT); //インジェクション対策
      $stmt->execute($data);
      $city = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      header('Location: orderlist.php');
      exit();
      }
      // v($order);
      // v($city);

    $errors = array();
    $offer_price = '';
    $delivery_deadline = '';
    $delivery = '';
    $comment = '';


    // offerdetil.php (バリデーション処理Ver古)
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
      $_POST['input_offer_price'] = $_SESSION['register']['offer_price'];
      $_POST['input_delivery_deadline'] = $_SESSION['register']['delivery_deadline'];
      $_POST['input_delivery'] = $_SESSION['register']['delivery'];
      $_POST['input_comment'] = $_SESSION['register']['comment'];
      $errors['rewrite'] = true;
    }

    if (!empty($_POST)) {
        $offer_price = $_POST['input_offer_price'];
        $delivery_deadline = $_POST['input_delivery_deadline'];
        $delivery = $_POST['input_delivery'];
        $comment = $_POST['input_comment'];

        // 空チェック
        if ($offer_price == '') {
            $errors['offer_price'] = 'blank';
        }
        if ($delivery_deadline == '') {
            $errors['delivery_deadline'] = 'blank';
        }
        if ($delivery == '') {
            $errors['delivery'] = 'blank';
        }
        if ($comment == '') {
            $errors['comment'] = 'blank';
        }

        // v($errors);

        if (empty($errors)) {
        $_SESSION['register']['offer_price'] = $_POST['input_offer_price'];
        $_SESSION['register']['delivery_deadline'] = $_POST['input_delivery_deadline'];
        $_SESSION['register']['delivery'] = $_POST['input_delivery'];
        $_SESSION['register']['comment'] = $_POST['input_comment'];
        header('Location: offerdetailcheck.php?orders_id='.$order_id); //文字連結
        exit();
        }
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
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="assets/ico/favicon.png">

  <link href="assets/css/hover_pack.css" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/colors/color-74c9be.css" rel="stylesheet">    
  <link href="assets/css/animations.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  
  
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
<body style="margin-top: 60px; background: #E4E6EB;">
  <?php require('navbar.php'); ?>

  <div class="container" style="opacity: 0.9;">
    <div class="row">
      <!-- ここから -->
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-left content_header">依頼詳細</h2>
          <!-- ユーザー情報表示 -->
          <div class="row">
              <div class="col-lg-5" style="margin:30px auto">
                  <div class="media">
                      <a class="pull-left" href="#">
                          <img class="media-object dp img-circle" src="assets/img/team/gianni.png" style="width: 100px;height:100px;">
                      </a>
                      <div class="media-body">
                          <h4 class="media-heading">Hardik Sondagar <small> India</small></h4>
                          <h5>Software Developer at <a href="http://gridle.in">Gridle.in</a></h5>
                          <hr style="margin:8px auto">

                          <span class="label label-default">HTML5/CSS3</span>
                          <span class="label label-default">jQuery</span>
                          <span class="label label-info">CakePHP</span>
                          <span class="label label-default">Android</span>
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
        <h3 class="text-left content_header">引受け内容詳細</h3>
        <form method="POST" action="offerdetail.php?orders_id=<?php echo $order_id ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label for="offer_price">引受価格</label>
            <input type="text" name="input_offer_price" class="form-control" id="offer_price" placeholder="¥3,000" value="<?php echo $offer_price; ?>">
            <?php if(isset($errors['offer_price']) && $errors['offer_price'] == 'blank'){ ?>
              <p class="text-danger">希望引受け価格を入力して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="delivery_deadline">引渡期限</label>
            <input type="date" name="input_delivery_deadline" class="form-control" id="delivery_deadline" placeholder="2017/10/02" value="<?php echo $delivery_deadline; ?>">
            <?php if(isset($errors['delivery_deadline']) && $errors['delivery_deadline'] == 'blank'){ ?>
              <p class="text-danger">引渡期限を入力して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="delivery">引渡方法</label>
            <input type="text" name="input_delivery" class="form-control" id="delivery" placeholder="手渡し" value="<?php echo $delivery; ?>">
            <?php if(isset($errors['delivery']) && $errors['delivery'] == 'blank'){ ?>
              <p class="text-danger">引渡方法を入力して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="comment">コメント</label>
            <input type="text" name="input_comment" class="form-control" id="comment" placeholder="依頼内容の詳細をご記入下さい" value="<?php echo $comment; ?>">
            <?php if(isset($errors['comment']) && $errors['comment'] == 'blank'){ ?>
              <p class="text-danger">詳細を記入して下さい</p>
            <?php } ?>
          </div>
          <input type="submit" class="btn btn-default" value="確認">
        </form>
      </div>
    </div>
  </div>
  <! ========== FOOTER ======================================================================================================== 
  =============================================================================================================================>    
  
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
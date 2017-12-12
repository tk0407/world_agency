<?php
session_start();
require('dbconnect.php');
require('functions.php');
require('signin_check.php');

if (!isset($_REQUEST['user_id'])) {
  header('Location: users.php');
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

  <title>MARCO - One Page Bootstrap 3 Theme</title>

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

    <!-- ---------------------------オファー一覧------------------------------- -->

    <div id="white">
      <div class="container">
        <div class="row mt centered ">
          <div class="col-xs-8 col-xs-offset-2">
            <h3><?php echo $signin_user['firstname']; ?>さんが出している依頼一覧</h3>
            <hr>
          </div><!-- /col-lg-4 -->
        </div><!-- /row -->


        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
          <!-- タイムライン -->
          <?php for($i=0;$i<$c;$i++){ ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-3">
                <img src="trade_img/<?php echo $orders[$i]['images']; ?>" width="80">
              </div>
              <div class="col-xs-6">
                <a href=""><span style="font-size: 24px;"><?php echo $orders[$i]['title'] ?></span></a><br>
                個数　<?php echo $orders[$i]['amount']; ?>個　依頼日時　<?php echo $orders[$i]['created']; ?>
              </div>
              <div class="col-xs-3">
                <?php if ($orders[$i]['flag'] == 1): ?>
                  <a href="offeragentlist.php?orders_id=<?php echo $orders[$i]['id'] ?>">
                    <button class="btn btn-info btn-block">オファー受付中</button>
                  </a>
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
            <h3><?php echo $signin_user['firstname']; ?>さんが引き受けている依頼一覧</h3>
            <hr>
          </div><!-- /col-lg-4 -->
        </div><!-- /row -->


        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
          <!-- タイムライン -->
          <?php for($i=0;$i<$ca;$i++){ ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-3">
                <img src="trade_img/<?php echo $agent[$i]['images']; ?>" width="80">
              </div>
              <div class="col-xs-6">
                <a href=""><span style="font-size: 24px;"><?php echo $agent[$i]['title'] ?></span></a><br>
                個数　<?php echo $agent[$i]['amount']; ?>個　依頼日時　<?php echo $agent[$i]['created']; ?>
              </div>
              <div class="col-xs-3">
                <?php if ($agent[$i]['flag'] == 1): ?>
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

<?php
session_start();
require('dbconnect.php');
require('functions.php');
require('signin_check.php');

    // if (!isset($_REQUEST['orders_id']) && ($_POST['feed'])) {
    //     header('Location: users.php');
    //     exit();
    // }

if (isset($_REQUEST['agent_id'])) {
  $agent_id = $_REQUEST['agent_id'];

      // エージェント情報取得
  $sql = 'SELECT * FROM users WHERE id = ?';
  $data = array($agent_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $agent = $stmt->fetch(PDO::FETCH_ASSOC);

}

if (!empty($_POST)) {

        $order_id = $_POST['order_id'];

        $sql = 'UPDATE orders SET flag = ? WHERE id = ?'; // SQL文を文字で用意
        $data = array(3,$order_id); // ?に入れるデータを配列で用意
        $stmt = $dbh->prepare($sql); // SQL文をデータベースにセット
        $stmt->execute($data); // SQL文を実行

        header('Location: orderstatus.php?user_id=' . $signin_user['id']);
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

    <! ========== BLOG POSTS ==================================================================================================== 
    =============================================================================================================================>    
    <div id="white">
      <div class="container"> 

        <br>
        <br>

        <!-- -------------商品情報-------------------- -->

        <div class="row mt centered ">
          <div class="col-lg-4 col-lg-offset-4">
            <h3>今回のエージェントを評価する</h3>
            <hr>
          </div><!-- /col-lg-4 -->
        </div><!-- /row -->

        <div class="container">
          <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
              <img src="user_profile_img/<?php echo $agent['img_name']; ?>"  class="img-circle img-responsive center-block" width="80">
              <p class="text-center" style="font-size: 24px;"><?php echo $agent['firstname'] ?> さん</p>
            </div>
          </div>
        </div>



        <!-- -------------星をつける-------------------- -->



        <div class="container">
          <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
              <!-- Fixed navbar -->
              <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Demo</a>
                  </div>
                  <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                      <li><a href="../navbar/">Default</a></li>
                    </ul>
                  </div><!--/.nav-collapse -->
                </div>
              </nav>

              <div class="row mt centered">
                <div class="col-xs-8 col-xs-offset-2">
                  <div class="">
                    <h4>ユーザー平均評価</h4>
                    <h2 class="bold padding-bottom-7"><?php echo $agent['evaluate_id'] ?><small>/ 5</small></h2>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                      <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                      <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                      <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                      <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                      <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- -------------------メッセージフォーム----------------------------- -->
            <div class="col-xs-8 col-xs-offset-2">
              <!-- フィードと投稿フォーム -->
              <form method="POST" action="agentreview.php">
                <textarea class="form-control" name="feed"></textarea>
                <?php if(isset($errors['feed']) && $errors['feed'] == 'blank'){?>
                <p class="text-danger">投稿データを入力してください</p>
                <?php } ?>
                <input type="hidden" name="order_id" value="<?php echo $_REQUEST['order_id']; ?>">
                <input type="submit" value="送信" class="btn btn-primary">
              </form>
            </div>


          </div><!-- /container -->
        </div><!-- /black -->
      </div>
    </div>
    <br>


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

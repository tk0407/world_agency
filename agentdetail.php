    <?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    require('signin_check.php');

        // if (!isset($_REQUEST['agent_id'])) {
        //     header('Location: users.php');
        //     exit();
        // }

    if (isset($_REQUEST['agent_id'])) {
      $agent_id = $_REQUEST['agent_id'];
      $order_id = $_REQUEST['order_id'];


        // エージェント情報取得
      $sql = 'SELECT * FROM users WHERE id = ?';
      $data = array($agent_id);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $agent = $stmt->fetch(PDO::FETCH_ASSOC);

        // オーダー情報取得
      $sql = 'SELECT * FROM orders WHERE id = ?';
      $data = array($order_id);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // オファー情報取得
      $sql = 'SELECT * FROM offers WHERE agent_id = ? AND order_id = ?';
      $data = array($agent_id,$order_id);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $offer = $stmt->fetch(PDO::FETCH_ASSOC);

      $_SESSION['order']['id'] = $order['id'];
      $_SESSION['agent']['id'] = $agent_id;
    }

    if (!empty($_POST)) {

            $sql = 'UPDATE orders SET flag = ?, progress = ?, agent_id = ? WHERE id = ?'; // SQL文を文字で用意
            $data = array(2,2,$_SESSION['agent']['id'],$_SESSION['order']['id']); // ?に入れるデータを配列で用意
            $stmt = $dbh->prepare($sql); // SQL文をデータベースにセット
            $stmt->execute($data); // SQL文を実行

            unset($_SESSION['agent']);
            unset($_SESSION['order']);
            header('Location: thanksordercomplete.php');
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
        <div class="row mt centered ">
          <div class="col-lg-4 col-lg-offset-4">
            <h3>引受内容・エージェント詳細</h3>
            <hr>
          </div><!-- /col-lg-4 -->
        </div><!-- /row -->

        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
              <ul class="list-group" id="contact-list">
                <li class="list-group-item">
                  <div class="col-xs-4 col-xs-offset-4 centered">
                    <img src="order_images/<?php echo $order['images']; ?>" width="140"><br>
                    <?php echo $order['item_name']; ?><br>
                  </div>


                  <div class="col-xs-12">
                    <ul class="list-group" id="contact-list">
                      <li class="list-group-item">
                        <a href="">
                          <div class="col-xs-4 centered">
                            <img src="user_profile_img/<?php echo $agent['img_name']; ?>" class="img-circle img-responsive img-thumbnail" width="140"><br>
                            <?php echo $agent['firstname']; ?>さん<br>
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
                         </div>
                         <div class="col-xs-3">
                          <ol>
                            <br>
                            <br>
                            <li><strong>価格</strong></li>
                            <li><strong>引渡日</strong></li>
                            <li><strong>引渡方法</strong></li>
                            <li><strong>コメント</strong></li>
                          </ol>

                        </div>

                        <div class="col-xs-5">
                          <ul>
                            <br>
                            <br>
                            <?php echo $offer['offer_price']; ?><br>
                            <?php echo $offer['delivery_deadline']; ?><br>
                            <?php echo $offer['delivery']; ?><br>
                            <?php echo $offer['comment']; ?><br>
                          </ul>
                        </div>
                        <div class="clearfix"></div>
                      </a>
                    </li>
                  </ul>
                </div>

                <div class="form-group">
                  <div class="col-xs-12">
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
                  <div class="col-xs-12">
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
                  <div class="col-xs-12">
                    <label>自己紹介</label>
                    <ul class="list-group" id="contact-list">
                      <li class="list-group-item">
                        <?php echo $agent['profile']; ?>
                        <div class="clearfix"></div>
                      </li>
                    </ul>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-sm-offset-2 centered">
                  <form method="POST" action="agentdetail.php">
                    <input type="hidden" name="action" value="submit">
                    <input type="submit" class="btn btn-primary" value="このエージェントに依頼する">
                  </form>
                </div>

                <div class="clearfix"></div>

              </li>
            </ul>
          </div>
        </div>
      </div>


    </div><!-- /container -->
  </div><!-- /black -->


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

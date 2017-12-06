<?php
    session_start();
    // requireでfunctionsの関数を呼び出す。linkのようなモノ
    require('dbconnect.php');
    require('functions.php');
    $signin_user['id'] = 1; //後でsignin idをここに表示できるようにする。


    // header('Location: tradelist.php');
    // exit();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="assets/ico/favicon.png">
  <title>World Agency</title>
    <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/hover_pack.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/colors/color-74c9be.css" rel="stylesheet">
  <link href="assets/css/animations.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  
  
  <!-- JavaScripts needed at the beginning
  ================================================== -->
  <script type="text/javascript" src="http://alvarez.is/demo/marco/assets/js/twitterFetcher_v10_min.js"></script>
  <!-- MAP SCRIPT - ALL CONFIGURATION IS PLACED HERE - VIEW OUR DOCUMENTATION FOR FURTHER INFORMATION -->
  

  
  
  <!-- Main Jquery & Hover Effects. Should load first -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="assets/js/hover_pack.js"></script>
  
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
  <title>World Agency</title>
  </head>
<body>
  <div class="container"> 

    <div class="row mt centered ">
      <div class="col-lg-4 col-lg-offset-4">
        <h3>海外のエージェントに依頼をする</h3>
        <hr>
      </div>
    </div><!-- /row -->

    <div class="row mt">
      <div class="col-lg-4 col-md-4 col-xs-12 desc">
        <a href=_order_detail1.php? class="btn btn-info"><img width="350" src="assets/img/portfolio/port06.jpeg" alt="" />
          <div class="b-wrapper">
              <p class="">モノを依頼する</p>
          </div>
        </a>
        <p>The Sky Is The Limit</p>
        <p class="lead">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <hr-d>
        <p class="time"><i class="fa fa-comment-o"></i> 3 | <i class="fa fa-calendar"></i> 14 Nov.</p>
      </div><!-- col-lg-4 -->
      
      <div class="col-lg-4 col-md-4 col-xs-12 desc">
        <a href=_order_detail2.php? class="btn btn-info"><img width="350" src="assets/img/portfolio/information2.jpg" alt="" />
          <div class="b-wrapper">
              <p class="">情報を依頼する</p>
          </div>
        </a>
        <p>Another Cool Stuff</p>
        <p class="lead">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <hr-d>
        <p class="time"><i class="fa fa-comment-o"></i> 1 | <i class="fa fa-calendar"></i> 13 Oct.</p>
      </div><!-- col-lg-4 -->
      
      <div class="col-lg-4 col-md-4 col-xs-12 desc">
        <a href=_order_detail3.php? class="btn btn-info"><img width="350" src="assets/img/portfolio/pictures3.jpg" alt="" />
          <div class="b-wrapper">
              <p class="">データを依頼する</p>
          </div>
        </a>
        <p>This Is Awesome</p>
        <p class="lead">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <hr-d>
        <p class="time"><i class="fa fa-comment-o"></i> 1 | <i class="fa fa-calendar"></i> 13 Oct.</p>
      </div><!-- col-lg-4 -->
      
    </div><!-- /row -->
  </div><!-- /container -->

  <div class="container" style="opacity: 0.9;">
    <div class="row">
      <!-- ここから -->
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">依頼を受ける</h2>
        <form method="POST" action="_order_detail1.php" enctype="multipart/form-data">
          <!-- 下記、国のDBからスクロールして国名を取ってくる -->
          <div class="form-group">
            <label for="country">国</label>
            <select type="text" name="input_country" class="form-control">
              <?php foreach($countries as $country): ?>
                <option value="<?= $country['id'] ?>"><?= $country['country_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
            <!-- $_POST['hoge'] = 3 -->
            <!-- 3 -->
            <!-- 下記、都市のDBからスクロールして都市名を取ってくる -->
          <div class="form-group">
            <label for="city">都市</label>
            <select type="text" name="input_city" class="form-control">
              <?php foreach($cities as $city): ?>
                <option value="<?= $city['id'] ?>"><?= $city['city_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- 下記、カテゴリーのDBからスクロールしてカテゴリー名を取ってくる -->
          <div class="form-group">
            <label for="city">カテゴリー</label>
            <select type="text" name="input_city" class="form-control">
              <?php foreach($cities as $city): ?>
                <option value="<?= $city['id'] ?>"><?= $city['city_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
            <!-- $_POST['hoge'] = 3 -->
            <!-- 3 -->
          <input type="submit" class="btn btn-default" value="上記の項目で依頼を探す">
        </form>
      </div>
    </div>
  </div>


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
<?php
  session_start();
  require('dbconnect.php');
  require('signin_check.php');

?>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Woarld Agency</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0">
  <!-- 基本bootの下でfont awesome読み込む -->
  <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0/css/font-awesome.css">
  <link href="assets/css/hover_pack.css" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/colors/color-74c9be.css" rel="stylesheet">    
  <link href="assets/css/animations.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
</head>
<body style="margin-top: 50px">
  <?php require('navbar.php');?>
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">依頼完了</h2>
        <div class="text-center">
          <p>エージェントへの依頼が完了しました。</p>
          <p>今後の手順は下記のようになりますのでご確認ください。</p>
          <img src="assets/img/portfolio/orderprocess.jpg" alt="プロセス画像" width="100%" height="55%" class="img-responsive">
          <p>今回御依頼頂いた内容に対してエージェントからオファーが来ますので、<br>その際はマイページの新着情報をご確認ください。</p>
          <a href="mypage.php" class="btn btn-info">マイページへ</a>
        </div>
      </div>
    </div>
  </div>
  <?php require('footer.php');?>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
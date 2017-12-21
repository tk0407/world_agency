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
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />

  </head>

  <body style="margin-top:50px ; background: #FFFFFF;">
    <?php require('navbar.php'); ?>

  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">エージェント選択完了</h2>
        <div class="text-center">
          <p>エージェントの選択が完了しました。</p>
          <p>今後の手順は下記のようになりますのでご確認ください。</p>
          <img src="assets/img/portfolio/orderprocess.jpg" alt="プロセス画像" class="img-rounded img-responsive img-thumbnail" width="100%" height="55%" />
          <p>選択したエージェントにメッセージを送りましょう<br>マイページをご確認ください。</p>
          <a href="mypage.php" class="btn btn-info">マイページへ</a>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>



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

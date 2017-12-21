<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    // require('signin_check.php');
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

  <body id="home">


  <! ========== HEADERWRAP ==================================================================================================== 
  =============================================================================================================================>
    <div id="headerwrap">
      <div class="container">
      <div class="row centered">
        <div class="col-lg-8 col-lg-offset-2 mt">
          <h1 class="animation slideDown" style="font-size: 1700%">WA</h1>
        </div>
        <div class="col-lg-12">
          <p>
            <a href="register/signup.php"> <button class="square_btn btn btn-theme" style="width: auto; height: 10%; text-align: center; font-size: 150%;">新規登録</button></a>
            <a href="signin.php"> <button class="square_btn btn btn-theme" style="width: auto; height: 10%; text-align: center; font-size: 150%;">ログイン</button></a>
          </p>
        </div>
      </div><!-- /row -->
      </div><!-- /container -->
    </div> <!-- /headerwrap -->

  <! ========== NAVBAR ==================================================================================================== 
  =============================================================================================================================>
  <nav class="navbar navbar-default navbar-fixed-top" id="navtoppage">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="index.php" class="navbar-brand navbar-font-white">World Agency</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse1">
        <ul class="nav navbar-nav">
          <li><a class="navbar-font-white" href="orderlist.php">依頼一覧</a></li>
          <li><a class="navbar-font-white" href="mypage.php">マイページ</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <! ========== BLOG POSTS ==================================================================================================== 
  =============================================================================================================================>    
  <div class="container"> 
    <div class="pull-right">
    </div>

    <div class="row mt centered ">
      <p class="text-center"></p>
    </div>
    <h1 style="font-family: 'Ruda', sans-serif;font-weight: 900;color: #2c3e50;text-align: center;line-height: 40px;">海の向こうをもっと身近に</h1>
    <br>
    <h4 style="font-family: 'Ruda', sans-serif;font-weight: 900;color: #2c3e50;text-align: center;line-height: 40px; margin-bottom: 10%;">World Agencyとは、海外にいる人と自分の国には無いけど海外にあるものが欲しい人を繋げるサービスです。<br>自分から欲しいものを依頼する形式なので、本当に欲しいものが見つけられます。
    </h4>
      <div class="mt">
        <div class="row mt">
          <div class="col-lg-4 col-md-4 col-xs-12 desc">
            <a class="b-link-fade b-animate-go" href="#"><img width="350" src="assets/img/background/mono1.jpg" alt="" />
              <div class="b-wrapper">
                  <h4 class="b-from-left b-animate b-delay03">Post 1</h4>
                  <p class="b-from-right b-animate b-delay03">Read More.</p>
              </div>
            </a>
            <p>海外でしか手に入らないモノ</p>
            <p class="lead">  世の中には海外で購入したほうが安いもの、海外でしか手に入らないモノがたくさんあります。ここではそういったモノを今現地にい    る人達に頼んで簡単に手に入れましょう。</p>
          </div><!-- col-lg-4 -->
          
          <div class="col-lg-4 col-md-4 col-xs-12 desc">
            <a class="b-link-fade b-animate-go" href="#"><img width="350" src="assets/img/background/research.jpeg" alt="" />
              <div class="b-wrapper">
                  <h4 class="b-from-left b-animate b-delay03">Post 2</h4>
                  <p class="b-from-right b-animate b-delay03">Read More.</p>
              </div>
            </a>
            <p>海外でしか手に入らない情報</p>
            <p class="lead">  世界中にある観光地の数々、昔行ったことはあるけれど今どうなっているか最新の情報などは現地にいる人でないとわかりません。ま  た、今その土地 で流行っているモノやサービスの情報は自国にとってとても有益であったりします。これらの情報を現地にいる人に調達してもらいましょう  。</p>
          </div><!-- col-lg-4 -->
          
          <div class="col-lg-4 col-md-4 col-xs-12 desc">
            <a class="b-link-fade b-animate-go" href="#"><img width="350" src="assets/img/background/photos.jpeg" alt="" />
              <div class="b-wrapper">
                  <h4 class="b-from-left b-animate b-delay03">Post 3</h4>
                  <p class="b-from-right b-animate b-delay03">Read More.</p>
              </div>
            </a>
            <p>海外の写真等のデータ</p>
            <p class="lead">  WEBサイトを運営したり、海外に関してのビジネスを運営しているとどうしてもその国、土地の写真やデータが必要になる時があります    。ここではそういったデータも今現地にいる人達に依頼してみましょう。</p>
          </div><!-- col-lg-4 -->
    
          <div class="row mt centered ">
            <div class="col-lg-4 col-lg-offset-4">
              <p class="mt"><a href="orderofferpage.php"><button class="square_btn btn btn-theme" style="width: auto; height: 100%; text-align:    center; font-size: 150%;">依頼する/依頼を受ける</button></a></p>
              <hr>
            </div>
          </div><!-- /row -->
      </div>  
    </div><!-- /row -->
  </div><!-- /container -->

  <! ========== CALL TO ACTION 1 ============================================================================================== 
  =============================================================================================================================>    
    <div id="cta01">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
            <h2>終着点は重要じゃない。<br>旅の途中でどれだけ楽しいことを<br>やり遂げているかが大事なんだ。<br><br>-　スティーブ・ジョブズ</h2>
          </div>
        </div><!-- /row -->
      </div><!-- /container -->
    </div><! --/cta01 -->

  <! ========== PORTFOLIO SECTION ============================================================================================= 
  =============================================================================================================================>    
  <div class="container">
    <div class="row mt centered ">
      <div class="col-lg-4 col-lg-offset-4">
        <h3>最新の取引</h3>
        <hr>
      </div>
    </div><!-- /row -->
    <div class="row mt centered"> 
      <div class="col-lg-4 desc">
        <a class="b-link-fade b-animate-go" href="#"><img style="object-fit: contain; width: 300px; height: 200px;" src="assets/img/portfolio/enjoi_10017288_wht_whitey_panda_logo_wide_r7_1024x1024.jpg" alt="" />
          <div class="b-wrapper">
              <h4 class="b-from-left b-animate b-delay03">Project 1</h4>
              <p class="b-from-right b-animate b-delay03">View Details</p>
          </div>
        </a>
        <p>enjoy -<i class="fa fa-heart-o"></i></p>
      </div>
      <div class="col-lg-4 desc">
        <a class="b-link-fade b-animate-go" href="#"><img style="object-fit: contain; width: 300px; height: 200px;" src="assets/img/portfolio/Body&bath.jpg" alt="" />
          <div class="b-wrapper">
              <h4 class="b-from-left b-animate b-delay03">Project 2</h4>
              <p class="b-from-right b-animate b-delay03">View Details</p>
          </div>
        </a>
        <p>Bath&Body - <i class="fa fa-heart-o"></i></p>
      </div>
      <div class="col-lg-4 desc">
        <a class="b-link-fade b-animate-go" href="#"><img  style="object-fit: contain; width: 300px; height: 200px;" src="assets/img/portfolio/peackdesign20l_charcoal.jpg" alt="" />
          <div class="b-wrapper">
              <h4 class="b-from-left b-animate b-delay03">Project 3</h4>
              <p class="b-from-right b-animate b-delay03">View Details</p>
          </div>
        </a>
        <p>Peakdesign everyday backpack 20L - <i class="fa fa-heart-o"></i></p>
      </div>
    </div><!-- /row -->
    <div class="row mt centered"> 
      <div class="col-lg-4 desc">
        <a class="b-link-fade b-animate-go" href="#"><img style="object-fit: contain; width: 300px; height: 200px;" src="assets/img/portfolio/sabon.jpg" alt="" />
          <div class="b-wrapper">
              <h4 class="b-from-left b-animate b-delay03">Project 4</h4>
              <p class="b-from-right b-animate b-delay03">View Details</p>
          </div>
        </a>
        <p>Sabon   - <i class="fa fa-heart-o"></i></p>
      </div>
      <div class="col-lg-4 desc">
        <a class="b-link-fade b-animate-go" href="#"><img style="object-fit: contain; width: 300px; height: 200px;" src="assets/img/portfolio/JollibeeT2.jpg" alt="" />
          <div class="b-wrapper">
              <h4 class="b-from-left b-animate b-delay03">Project 5</h4>
              <p class="b-from-right b-animate b-delay03">View Details</p>
          </div>
        </a>
        <p>JollibeeT - <i class="fa fa-heart-o"></i></p>
      </div>
      <div class="col-lg-4 desc">
        <a class="b-link-fade b-animate-go" href="#"><img style="object-fit: contain; width: 300px; height: 200px;" src="assets/img/portfolio/papayasoap.jpg" alt="" />
          <div class="b-wrapper">
              <h4 class="b-from-left b-animate b-delay03">Project 6</h4>
              <p class="b-from-right b-animate b-delay03">View Details</p>
          </div>
        </a>
        <p>Papaya Soap - <i class="fa fa-heart-o"></i></p>
      </div>
    </div><!-- /row -->

    <div class="row mt centered">
      <div class="col-lg-4 col-lg-offset-4">
          <a href="orderofferpage.php"><button class="square_btn btn btn-theme" style="width: auto; height: 100%; text-align:    center; font-size: 150%;">依頼する/依頼を受ける</button></a>
      </div>
    </div><!-- /row -->
  </div><!-- /container -->

  <! ========== BRANDS & CLIENTS =============================================================================================== 
  =============================================================================================================================>    
  <div id="grey">
    <div class="container">
      <div class="row mt centered ">
        <div class="col-lg-4 col-lg-offset-4">
          <h3>掲載メディア</h3>
          <hr>
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->
      
      <div class="row centered">
        <div class="col-lg-3 pt">
          <img class="img-responsive" src="assets/img/clients/Wired (1).png" alt="">
        </div>
        <div class="col-lg-3 pt">
          <img class="img-responsive" src="assets/img/clients/tripadvisor (1).png" alt="">
        </div>
        <div class="col-lg-3 pt">
          <img class="img-responsive" src="assets/img/clients/techcrunch.png" alt="">
        </div>
        <div class="col-lg-3 pt">
          <img class="img-responsive" src="assets/img/clients/yt_logo_rgb_light.png" alt="">
        </div>

      </div><!-- /row -->
    </div><!-- /container -->
  </div><!-- /grey -->

  
  <! ========== BLACK SECTION ================================================================================================= 
  =============================================================================================================================>    
  <div id="black">
    <div class="container">
      <div class="row mt centered">
        <div class="col-lg-4 col-lg-offset-4">
          <h3>対象都市</h3>
          <hr>
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->
      
      <div class="row mt">
        <div class="col-lg-8 col-lg-offset-2">
          <p>現段階の依頼対象都市は以下となります。<br>アメリカ（ハワイ/ニューヨーク/ロサンゼルス）、フランス(パリ/ニース/リヨン)、中国（香港、上海、北京）、タイ（バンコク/プーケット/パタヤ）、日本（東京/大阪/京都）</p>
        </div><! --/col-lg-8 -->
      </div><!-- /row -->
    </div><!-- /container -->
  </div><!-- /black -->


  <! ========== FEATURED ICONS ================================================================================================ 
  =============================================================================================================================>    
    <div id="white">
      <div class="container">
        <div class="row mt">
          <div class="col-lg-4 col-lg-offset-4 centered">
            <h3>ご利用の流れ</h3>
            <hr>
          </div>
        </div>
        <div class="row mt">
          <div class="col-lg-3">
            <p class="capitalize">1&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa fa-laptop" style="font-size: 60px;" aria-hidden="true"></i></p>
            <h4>依頼</h4>
            <p>お客様がお望みのカテゴリーから依頼内容をご入力いただき、世界中にいるエージェントに向けてオーダーを出していただきます。</p>
          </div>
          <div class="col-lg-3">
            <p class="capitalize">2&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa fa-users" style="font-size: 60px;" aria-hidden="true"></i></p>
            <h4>選定</h4>
            <p>お客様が送っていただいた依頼内容に対して現地にいるエージェントからオファーが送られてきますので、ご自身で要望に一番沿ったエージェントをお選び下さい。</p>
          </div>
          <div class="col-lg-3">
            <p class="capitalize">3&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa fa-comments" style="font-size: 60px;" aria-hidden="true"></i></p>
            <h4>詳細のやり取り/調達</h4>
            <p>エージェントとのマッチングが完了いたしましたら後は依頼内容の詳細をメッセージを通してお伝え下さい。その後、依頼品をエージェントに調達していただきます。</p>
          </div>
  
          <div class="col-lg-3">
            <p class="capitalize">4&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa fa-gift" style="font-size: 60px;" aria-hidden="true"></i></p>
            <h4>お支払/取引完了</h4>
            <p>エージェントより依頼の品をお受け取り次第、お支払をしていただきます。お客様からエージェントに今回の取引について評価をしていただき、もし今回の取引を気に入っていただけたのであればエージェントをフォーローできますので次回のお取引もお気に入りのエージェント様に依頼が可能です。</p>
          </div>
        </div><!-- /row -->
      </div><!-- /container -->
    </div><!-- /white -->

  <! ========== CALL TO ACTION 2 ============================================================================================== 
  =============================================================================================================================>    
    <div id="cta02">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
            <h2>“The world is a book, and those who do not travel read only one page.”<br>
             ―世界は一冊の本である。旅をしない者は、1ページしか読んでいないのだ―<br>アウグスティヌス - 哲学者</h2>
          </div>
        </div><!-- /row -->
      </div><!-- /container -->
    </div><! --/cta02 -->

  <! ========== FEATURED ICONS ================================================================================================ 
  =============================================================================================================================>    
    <div class="container">
      <div class="row mt">
        <div class="col-lg-4 centered si">
          <i class="fa fa-shopping-bag" aria-hidden="true"></i>
          <h4>ブランド品</h4>
          <p>自分の住んでいる国では売っていない、もしくは高すぎるものを海外から取り寄せましょう。</p>
        </div>
        <div class="col-lg-4 centered si">
          <i class="fa fa-futbol-o" aria-hidden="true"></i>
          <h4>スポーツ用品</h4>
          <p>日本で買う場合は元の価格より2倍,3倍ほどかかってしまったり、そもそも購入すること自体難しいスポーツ製品はWAを利用し手に入れましょう。</p>
        </div>
        <div class="col-lg-4 centered si">
          <i class="fa fa-globe" aria-hidden="true"></i>
          <h4>最新観光地情報</h4>
          <p>現地にいないとなかなか知り得ない情報や、かなり昔に訪れた場所の情報をWAを使ってアップデートしましょう。</p>
        </div>

        <div class="col-lg-4 centered si">
          <i class="fa fa-search" aria-hidden="true"></i>
          <h4>市場調査</h4>
          <p>まだ日本にはない海外で流行っている物や現地で気になるビジネスモデルの情報収集をWAを通して行いましょう。</p>
        </div>
        <div class="col-lg-4 centered si">
          <i class="fa fa-picture-o" aria-hidden="true"></i>
          <h4>画像</h4>
          <p>日本では撮影できない街や風景の画像を現地にいる人に撮ってもらいましょう。</p>
        </div>
        <div class="col-lg-4 centered si">
          <i class="fa fa-video-camera" aria-hidden="true"></i>
          <h4>動画</h4>
          <p>海外の映像を現地にいる人に撮影してもらいましょう。</p>
        </div>
      </div><!-- /row -->
    </div><!-- /container -->
    
  <! ========== OUR TEAM ====================================================================================================== 
  =============================================================================================================================>    
  
  <div id="white">
    <div class="container">
        <div class="row mt">
          <div class="col-lg-4 col-lg-offset-4 centered">
            <h3>Our Team</h3>
            <hr>
          </div>
        </div><! --/row -->
      
      <div class="row">
        <div class="col-lg-4 centered">
          <div class="members">
            <img src="assets/img/team/gianni.png" alt="">
            <div class="team-info">
              <div class="subhead">Co-founder<br>Developer</div>
              <h2 class="team-name">Kazu</h2>
              <p class="team-description"><i class="fa fa-facebook"></i><i class="fa fa-twitter"></i><i class="fa fa-dribbble"></i></p>
            </div>
          </div>
        </div><!-- /col-lg-4 -->
        
        <div class="col-lg-4 centered">
          <div class="members">
            <img src="assets/img/team/rebecca.png" alt="">
            <div class="team-info">
              <div class="subhead">Co-founder<br>HR Manager</div>
              <h2 class="team-name">Soyoka</h2>
              <p class="team-description"><i class="fa fa-facebook"></i><i class="fa fa-twitter"></i><i class="fa fa-dribbble"></i></p>
            </div>
          </div>
        </div><!-- /col-lg-4 -->
        
        <div class="col-lg-4 centered">
          <div class="members">
            <img src="assets/img/team/william.png" alt="">
            <div class="team-info">
              <div class="subhead">Founder/Designer</div>
              <h2 class="team-name">Takamasa</h2>
              <p class="team-description"><i class="fa fa-facebook"></i><i class="fa fa-twitter"></i><i class="fa fa-dribbble"></i></p>
            </div>
          </div>
        </div><!-- /col-lg-4 -->

      </div><! --/row --> 
    </div><! --/container -->
  </div><! --/white -->
  
  <! ========== BLACK SECTION ================================================================================================= 
  =============================================================================================================================>    
  <div id="black">
     <div class="container pt">
       <div class="row mt centered">
         <div class="col-lg-3">
           <p><i class="fa fa-camera"></i></p>
           <h1>21,337</h1>
           <hr>
           <h4>取引された写真の数</h4>
         </div>

         <div class="col-lg-3">
           <p><i class="fa fa-video-camera"></i></p>
           <h1>2,764</h1>
           <hr>
           <h4>取引された動画の数</h4>
         </div>

         <div class="col-lg-3">
           <p><i class="fa fa-file-text"></i></p>
           <h1>1,070</h1>
           <hr>
           <h4>取引された書類の枚数</h4>
         </div>

         <div class="col-lg-3">
           <p><i class="fa fa-gift"></i></p>
           <h1>209,706</h1>
           <hr>
           <h4>取引された物の数</h4>
         </div>

      </div><!-- /row -->
    </div><!-- /container -->
  </div><!-- /black -->

  <! ========== TESTIMONIAL CAROUSEL ========================================================================================== 
  =============================================================================================================================>    

  <div class="container">
      <div class="row mt">
        <div class="col-lg-4 col-lg-offset-4 centered">
          <h3>お客様の声</h3>
          <hr>
        </div>
      </div><! --/row -->
  
    <div class="row mt">
      <div class="col-lg-8 col-lg-offset-2 centered">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">       
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active">
              <h2>日本で買うと¥17,000程するスケートボードが、WAを使ったおかげで¥10,000で購入することが出来ました！</h2>
              <h5>田中 太郎</h5>
            </div>
            
            <div class="item">
              <h2>ハワイでしか売っていないソープをエージェントさんに買ってきて貰えて凄くハッピー！</h2>
              <h5>桜田 花子</h5>
            </div>
          </div><!-- /carousel-inner -->
        
        </div><! --/carousel-example -->    
      </div><!-- /col-lg-8 -->
    </div><! --/row -->
  </div><!-- /container -->


  
  <! ========== CALL TO ACTION BAR =============================================================================================== 
  =============================================================================================================================>    
  <div id="cta-bar">
    <div class="container">
      <div class="row centered">
        <a href="orderofferpage.php"><h4>依頼する/依頼を受ける</h4></a>
      </div>
    </div><!-- /container -->
  </div><!-- /cta-bar -->
  
  <! ========== FOOTER ======================================================================================================== 
  =============================================================================================================================>    
  
  <div id="f">
    <div class="container">
      <div class="row">
        <!-- ADDRESS -->
        <div class="col-lg-3">
          <h4>運営会社について</h4>
          <p>
            World Agencyとは<br/>
            運営会社<br/>
            利用規約<br/>
            プライバシーポリシー<br/>
            お問い合わせ<br/>
            FAQ<br/>
            ニュース<br/>
          </p>
          <p>
            <i class="fa fa-mobile"></i> +55 4893.8943<br/>
            <i class="fa fa-envelope-o"></i> wa@helloworld.com
          </p>
        </div><! --/col-lg-3 -->
        
        <!-- TWEETS -->
        <div class="col-lg-3">
          <h4>最近のツイート</h4>
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
          <p>Follow us <b>@World_Agency</b></p>
        </div><!-- /col-lg-3 -->
        
        <!-- LATEST POSTS -->
        <div class="col-lg-3">
          <h4>最新の情報</h4>
          <p>
            <i class="fa fa-angle-right"></i> モノの取引<br/>
            <i class="fa fa-angle-right"></i> 情報の取引<br/>
            <i class="fa fa-angle-right"></i> データの取引<br/>
          </p>
        </div><!-- /col-lg-3 -->
        
        <!-- NEW PROJECT -->
        <div class="col-lg-3">
          <h4>最新のお取引</h4>
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



  
  </body>
</html>

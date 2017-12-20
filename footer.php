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

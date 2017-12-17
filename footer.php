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
 <a href="#"><img class="img-responsive" src="http://localhost/1002_Web/World_Agency/assets/img/portfolio/port03.jpg" alt="" /></a>
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
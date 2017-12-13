  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="index.php" class="navbar-brand">World Agency</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="orderlist.php">依頼一覧</a></li>
          <li><a href="mypage.php">マイページ</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="assets/img/team/gianni.png" class="img-circle" width="18">
              
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="profile.php?user_id=<?= $signin_user['id'] ?>">My Profile</a></li>
              <li><a href="signout.php" style="color: #FF0000">Sign Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

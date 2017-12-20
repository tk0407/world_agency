<?php 

    if (isset($_SESSION['signin_user']['id'])) {
        // サインインしているユーザー情報をDB取得
    $sql = 'SELECT * FROM `users` WHERE `id`=?';
    $data = array($_SESSION['signin_user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

 ?>


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
          <li><a href="orderlist.php">依頼一覧</a></li>
          <li><a href="mypage.php">マイページ</a></li>
          <li><a href="orderstatus.php?user_id=<?php echo $signin_user['id']; ?>">取引一覧</a></li>
          <li><a href="register/edit_profile.php?id=<?php echo $signin_user['id']; ?>">プロフィール編集</a></li>
          <!-- <li><a href="mypage.php">お気に入り</a></li>
          <li><a href="mypage.php">評価</a></li>
          <li><a href="mypage.php">フォロー</a></li>
          <li><a href="mypage.php">フォロワー</a></li> -->
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="user_profile_img/<?php echo ($signin_user['img_name']);?>" class="img-circle" width="18">
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
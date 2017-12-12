<?php
    session_start();
    // requireでfunctionsの関数を呼び出す。linkのようなモノ
    require('dbconnect.php');
    require('functions.php');
    // require('signin_check.php');
    $signin_user['id'] = 1; //後でsignin idをここに表示できるようにする。

    if(!isset($_SESSION['register'])) {
      header('Location: _order_detail2.php');
      exit();
    }

    v($_POST);

    v($_SESSION['register']);

    $country = $_SESSION['register']['country'];
    $city_id = $_SESSION['register']['city'];
    $title = $_SESSION['register']['title'];
    $draft = $_SESSION['register']['draft'];
    $order_price = $_SESSION['register']['order_price'];
    $delivery_date = $_SESSION['register']['delivery_date'];
    $delivery_format = $_SESSION['register']['delivery_format'];
    $publication_period = $_SESSION['register']['publication_period'];
    $recruitment_numbers = $_SESSION['register']['recruitment_numbers'];
    $requirement_skills = $_SESSION['register']['requirement_skills'];
    $images = $_SESSION['register']['images'];
    $detail = $_SESSION['register']['detail'];
    $request = $_SESSION['register']['request'];
    $purpose = $_SESSION['register']['purpose'];
    $attached_file = $_SESSION['register']['attached_file'];
    $category = 2;

    $sql = 'SELECT * FROM `cities` WHERE id = ?';
    $data = array($city_id);
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $city, PDO::PARAM_INT); //インジェクション対策
    $stmt->execute($data);
    $city = $stmt->fetch(PDO::FETCH_ASSOC);
    // v($city);


    // 登録ボタンが押された時の処理
    if (!empty($_POST)) {
        echo '通過<br>';
        // $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO `orders` SET
          `city_id`=?
          ,`category`=?
          ,`title`=?
          ,`draft`=?
          ,`order_price`=?
          ,`delivery_date`=?
          ,`delivery_format`=?
          ,`publication_period`=?
          ,`recruitment_numbers`=?
          ,`requirement_skills`=?
          ,`images`=?
          ,`detail`=?
          ,`request`=?
          ,`purpose`=?
          ,`attached_file`=?
          ,`created`=NOW()
          ';
          // 上記が雛形の書き方
        $data = array($city_id,$category,$title,$draft,$order_price,$delivery_date,$delivery_format,$publication_period,$recruitment_numbers,$requirement_skills,$images,$detail,$request,$purpose,$attached_file);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        unset($_SESSION['register']);
        header('Location: thanksorder.php');
        exit();

    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>World Agency</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px; background-image: url(assets/img/portfolio/infoback1.jpg); background-position:center center; background-repeat:no-repeat; background-attachment: fixed; background-size: cover;">
  <div class="container" style="opacity: 0.86;">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">アカウント情報確認</h2>
        <div class="row">
          <div class="col-xs-4">
            <img src="order_images/<?php echo $images;?>" class="img-responsive img-thumbnail">
          </div>
          <div class="col-xs-8">
            <div>
              <span>都市</span>
              <p class="lead"><?php echo $city['city_name'];?></p>
            </div>
            <div>
              <span>タイトル</span>
              <p class="lead"><?php echo $title;?></p>
            </div>
            <div>
              <span>原稿数</span>
              <p class="lead"><?php echo $draft;?></p>
            </div>
            <div>
              <span>希望価格</span>
              <p class="lead"><?php echo $order_price;?></p>
            </div>
            <div>
              <span>希望受取日時</span>
              <p class="lead"><?php echo $delivery_date;?></p>
            </div>
            <div>
              <span>納品形式</span>
              <p class="lead"><?php echo $delivery_format;?></p>
            </div>
            <div>
              <span>掲載期限</span>
              <p class="lead"><?php echo $publication_period;?></p>
            </div>
            <div>
              <span>募集人数</span>
              <p class="lead"><?php echo $recruitment_numbers;?></p>
            </div>
            <div>
              <span>求めるスキル</span>
              <p class="lead"><?php echo $requirement_skills;?></p>
            </div>
            <div>
              <span>参考画像</span>
              <p class="lead"><?php echo $images;?></p>
            </div>
            <div>
              <span>詳細</span>
              <p class="lead"><?php echo $detail;?></p>
            </div>
            <div>
              <span>提案条件</span>
              <p class="lead"><?php echo $request;?></p>
            </div>
            <div>
              <span>利用用途/目的</span>
              <p class="lead"><?php echo $purpose;?></p>
            </div>
            <div>
              <?php if (!empty($attached_file)) { ?>
              <span>添付ファイル</span>
                <p class="lead">
                  <?php echo $attached_file ;?>
                  <?php } else { echo ""; ?>
                </p>
              <?php } ?>
            </div>
            <!-- ③ -->
            <form method="POST" action="_order_check2.php">
              <!-- ④ -->
              <a href="_order_detail2.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> |
              <!-- ⑤ -->
              <input type="hidden" name="action" value="submit">
              <input type="submit" class="btn btn-primary" value="依頼する">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
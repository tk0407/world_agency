<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    require('signin_check.php');
    
    // 依頼者が指定した都市とカテゴリーを受け取る。
    $_POST['city_id'] = $_POST['input_city'];
    $_POST['category'] = $_POST['input_category'];
    // v($_POST);
    // 依頼者が選択した項目に当てはまるオーダー内容取得
    // オーダーのトグル処理
    $city_id = $_POST['city_id'];
    $category = $_POST['category'];

    if (!empty($_POST['city_id'] && $_POST['category'])) {
      $sql = 'SELECT * FROM `orders` WHERE city_id = ? AND category = ? AND client_id != ? ';
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(1, $city_id, PDO::PARAM_INT); //インジェクション対策
      $stmt->bindParam(2, $category, PDO::PARAM_INT);
      $stmt->bindParam(3, $_SESSION['signin_user']['id'], PDO::PARAM_INT);
      $stmt->execute();
    } else {
      header('Location: orderofferpage.php');
      exit();
      }
    // orders配列に上で取ってきたorder内容を入れる
    $orders = array();
    while(true){
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record == false) {
            break;
        }
        $orders[] = $record;
    }
    $c = count($orders);
      v($c);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px; background: #E4E6EB;">
  <?php require('navbar.php'); ?>

  <div class="container">
    <div class="row mt centered ">
      <div class="col-xs-4 col-xs-offset-4">
        <h3>取引一覧</h3>
        <hr>
      </div><!-- /col-lg-4 -->
    </div><!-- /row -->


      <div class="col-xs-12">
        <!-- タイムライン -->
        <?php for($i=0;$i<$c;$i++){ ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-2">
                <img src="order_images/<?php echo $orders[$i]['images']; ?>" width="150">
              </div>
              <div class="col-xs-8">
                <a href=""><span style="font-size: 24px;"><?php echo $orders[$i]['title']; ?><?php echo $orders[$i]['item_name']; ?></span></a><br>
                個数　<?php echo $orders[$i]['amount']; ?><?php echo $orders[$i]['draft']; ?><?php echo $orders[$i]['file']; ?>個　依頼日時　<?php echo $orders[$i]['created']; ?>
              </div>
              <div class="col-xs-2">
                <a href="offerdetail.php?orders_id=<?php echo $orders[$i]['id'] ?>"><br>
                <button class="btn btn-info btn-block">確認</button>
                </a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
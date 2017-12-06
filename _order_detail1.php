<?php
    // 【このページで行っていること】このページではHTMLで入力したデータをこのPHP自身にPOST送信して、バリデーションを行う、次のページでheaderからデータを飛ばし最後確認ボタンを押したら登録されるように設定している。
    session_start();
    // requireでfunctionsの関数を呼び出す。linkのようなモノ
    require('dbconnect.php');
    require('functions.php');
    $signin_user['id'] = 1; //TODO 後でsignin idをここに表示できるようにする。

    // 国々の名前をDBから全件取得
    $sql = 'SELECT * FROM `countries` WHERE 1';
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $countries = [];
    while (true) {
        $country = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($country == false) {
            break;
        }
        $countries[] = $country;
    }
    // 各都市の名前をDBから全件取得
    $sql = 'SELECT * FROM `cities` WHERE 1';
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $cities = [];
    while (true) {
        $city = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($city == false) {
            break;
        }
        $cities[] = $city;
    }


    $errors = array();
    $country = '';
    $city = '';
    $item_name = '';
    $amount = '';
    $order_price = '';
    $delivery_date = '';
    $publication_period = '';
    $detail = '';
    $images = '';

    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
        $_POST['input_country'] = $_SESSION['register']['country'];
        $_POST['input_city'] = $_SESSION['register']['city'];
        $_POST['input_item_name'] = $_SESSION['register']['item_name'];
        $_POST['input_amount'] = $_SESSION['register']['amount'];
        $_POST['input_order_price'] = $_SESSION['register']['order_price'];
        $_POST['input_delivery_date'] = $_SESSION['register']['delivery_date'];
        $_POST['input_publication_period'] = $_SESSION['register']['publication_period'];
        $_POST['input_detail'] = $_SESSION['register']['detail'];
        $errors['rewrite'] = true; //これはコメントアウト下部分で本来行わなければ行けない処理。コメントアウトしてしまったのでここに追記
    }

    var_dump($_POST);


    if (!empty($_POST)) {
        $country = $_POST['input_country'];
        $city = $_POST['input_city'];
        $item_name = $_POST['input_item_name'];
        $amount = $_POST['input_amount'];
        $order_price = $_POST['input_order_price'];
        $delivery_date = $_POST['input_delivery_date'];
        $publication_period = $_POST['input_publication_period'];
        $detail = $_POST['input_detail'];


        // ユーザーネームの空チェック

        if ($country == '') {
            $errors['country'] = 'blank';
        }

        if ($city == '') {
            $errors['city'] = 'blank';
        }

        if ($item_name == '') {
            $errors['item_name'] = 'blank';
        }

        if ($amount == '') {
            $errors['amount'] = 'blank';
        }

        if ($order_price == '') {
            $errors['order_price'] = 'blank';
        }

        if ($delivery_date == '') {
            $errors['delivery_date'] = 'blank';
        }

        if ($publication_period == '') {
            $errors['publication_period'] = 'blank';
        }

        if ($detail == '') {
            $errors['detail'] = 'blank';
        }

        // 参考画像を送る処理
        if (!isset($_REQUEST['action'])) {
            $file_name1 = $_FILES['input_images']['name'];
        }
        // if (!empty($file_name1)) {
        //     // 画像選択時のバリデーション
        //     $file_type = substr($file_name1, -3);
        //     $file_type = strtolower($file_type); // 自己代入
        //     if ($file_type != 'png' && $file_type != 'jpg' && $file_type != 'gif') {
        //         $errors['images'] = 'type';
        //     }
        // } else {
        //     $errors['images'] = 'blank';
        // }

        // // 参考データファイルを送る処理
        if (!isset($_REQUEST['action'])) {
            $file_name2 = $_FILES['input_attached_file']['name'];
        }
        // if (!empty($file_name2)) {
        //     // データファイル選択時のバリデーション
        //     $file_type = substr($file_name2, -3);
        //     $file_type = strtolower($file_type); // 自己代入
        // } else {
        //     $errors['attached_file'] = 'blank';
        // }


        var_dump($errors);

        if (empty($errors)) {
          // バリデーション成功時の処理

          $submit_file_name1 = '';
          // ifの文で囲む。もし$_FILESが空だったらの場合
          if ($_FILES['input_images']['tmp_name'] != '') { // 画像選択時のみ処理
              $date_str = date('YmdHis');
              $submit_file_name1 = $date_str . $file_name1;
              move_uploaded_file($_FILES['input_images']['tmp_name'], 'order_images/' . $submit_file_name1);
          }

          $submit_file_name2 = '';
          if ($_FILES['input_attached_file']['tmp_name'] != '') { // 画像選択時のみ処理
              $date_str = date('YmdHis');
              $submit_file_name2 = $date_str . $file_name2;
              move_uploaded_file($_FILES['input_attached_file']['tmp_name'], 'order_attached_files/' . $submit_file_name2);
          }

          $_SESSION['register']['country'] = $_POST['input_country'];
          $_SESSION['register']['city'] = $_POST['input_city'];
          $_SESSION['register']['item_name'] = $_POST['input_item_name'];
          $_SESSION['register']['amount'] = $_POST['input_amount'];
          $_SESSION['register']['order_price'] = $_POST['input_order_price'];
          $_SESSION['register']['delivery_date'] = $_POST['input_delivery_date'];
          $_SESSION['register']['publication_period'] = $_POST['input_publication_period'];
          $_SESSION['register']['images'] = $submit_file_name1;
          $_SESSION['register']['detail'] = $_POST['input_detail'];
          $_SESSION['register']['attached_file'] = $submit_file_name2;//ここには上記画像ファイルを送った時と同じようにデータを送信する。この時、画像ファイルに限定しないので、データ形式のバリデーションはすべて取り外す。

          header('Location: _order_check1.php');
          exit();
        }
    }
?>
<!-- これがひな形 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>World Agency</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <!-- 基本bootの下でfont awesome読み込む -->
  <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px; background-image: url(assets/img/portfolio/formback3.jpg); background-position:center center; background-repeat:no-repeat; background-attachment: fixed; background-size: cover;">
  <div class="container" style="opacity: 0.9;">
    <div class="row">
      <!-- ここから -->
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">依頼内容 モノ</h2>
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
            <!-- 下記、都市のDBからスクロールして国名を取ってくる -->
          <div class="form-group">
            <label for="city">都市</label>
            <select type="text" name="input_city" class="form-control">
              <?php foreach($cities as $city): ?>
                <option value="<?= $city['id'] ?>"><?= $city['city_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
            <!-- $_POST['hoge'] = 3 -->
            <!-- 3 -->
          <div class="form-group">
            <label for="item_name">商品名</label>
            <input type="text" name="input_item_name" class="form-control" id="name" placeholder="Peak Design backpack 20L" value="<?php echo $item_name; ?>">
            <?php if(isset($errors['item_name']) && $errors['item_name'] == 'blank'){ ?>
              <p class="text-danger">商品名を入力して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="amount">個数</label>
            <input type="number" name="input_amount" class="form-control" id="amount" placeholder="３" value="<?php echo $amount; ?>">
            <?php if(isset($errors['amount']) && $errors['amount'] == 'blank'){ ?>
              <p class="text-danger">依頼個数を入力して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="order_price">希望価格</label>
            <input type="number" name="input_order_price" class="form-control" id="order_price" placeholder="¥3.000" value="<?php echo $order_price; ?>">
            <?php if(isset($errors['order_price']) && $errors['order_price'] == 'blank'){ ?>
              <p class="text-danger">希望価格を入力して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="delivery_date">希望受取日時</label>
            <input type="datetime-local" name="input_delivery_date" class="form-control" id="delivery_date" placeholder="2017/10/02 10:00" value="<?php echo $delivery_date; ?>">
            <?php if(isset($errors['delivery_date']) && $errors['delivery_date'] == 'blank'){ ?>
              <p class="text-danger">希望受取日時を入力して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="publication_period">掲載期限</label>
            <input type="date" name="input_publication_period" class="form-control" id="publication_period" placeholder="2017/10/02" value="<?php echo $publication_period; ?>まで">
            <?php if(isset($errors['publication_period']) && $errors['publication_period'] == 'blank'){ ?>
              <p class="text-danger">掲載期限を入力して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="img_name">参考画像</label>
            <input type="file" name="input_images" id="img_name" accept="image/*">
            <?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank'){ ?>
              <p class="text-danger">画像を選択して下さい</p>
            <?php } ?>
            <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type'){ ?>
              <p class="text-danger">拡張子が「jpg」「png」「gif」の画像を選択して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="detail">詳細</label>
            <input type="text" name="input_detail" class="form-control" id="detail" placeholder="依頼内容の詳細をご記入下さい" value="<?php echo $detail; ?>">
            <?php if(isset($errors['detail']) && $errors['detail'] == 'blank'){ ?>
              <p class="text-danger">詳細を記入して下さい</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="attached_file">添付ファイル</label>
            <input type="file" name="input_attached_file" id="attached_file">
            <?php if(isset($errors['attached_file']) && $errors['attached_file'] == 'blank'){ ?>
              <p class="text-danger">画像を選択して下さい</p>
            <?php } ?>
            <?php if(isset($errors['attached_file']) && $errors['attached_file'] == 'type'){ ?>
              <p class="text-danger">拡張子が「jpg」「png」「gif」の画像を選択して下さい</p>
            <?php } ?>
          </div>
          <input type="submit" class="btn btn-default" value="確認">
        </form>
      </div>
    </div>
  </div>
<script type="assets/js/jquery.js"></script>
<script type="assets/js/bootstrap.js"></script>
</body>
</html>
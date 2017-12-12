<?php

    // サインインチェック
    if (!isset($_SESSION['signin_user']['id'])) {
        header('Location: _signin.php');
        exit();
    }

    // サインインしているユーザー情報をDB取得
    $sql = 'SELECT * FROM `users` WHERE `id`=?';
    $data = array($_SESSION['signin_user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);
    // v($signin_user);

?>
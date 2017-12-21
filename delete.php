<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    require('signin_check.php');

    // 閲覧制限
    if (!isset($_REQUEST['delete_id'])) {
        header('Location: mypage.php');
        exit();
    }


    $delete_id = $_REQUEST['delete_id'];

    $sql = 'SELECT * FROM orders WHERE id=?';
    $data = array($delete_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($signin_user['id'] == $record['client_id']) {
        $sql = 'DELETE FROM orders WHERE id=?';
        $data = array($delete_id);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $sql = 'DELETE FROM offers WHERE order_id=?';
        $data = array($delete_id);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
    }


    header('Location: orderstatus.php?user_id=' . $signin_user['id']);
    exit();
?>
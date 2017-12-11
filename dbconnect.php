<?php
    $dsn = 'mysql:dbname=World_Agency;host=localhost';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    // SQL文にエラーがあった際、画面にエラーを出力する設定 基本は下記もセットで記入する。
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //エミュレーションを無効化
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->query('SET NAMES utf8');
?>
<?php
    session_start();
    // requireでfunctionsの関数を呼び出す。linkのようなモノ
    require('dbconnect.php');
    require('functions.php');
    $signin_user['id'] = 1; //後でsignin idをここに表示できるようにする。

    // 依頼者のユーザー情報を取ってくる

    // 依頼した内容の詳細をordersDBから一件取ってくる

    // エージェントがオファーする際の条件をPOST送信する

?>
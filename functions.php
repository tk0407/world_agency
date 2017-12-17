<?php
    // 定数
    define('DEBUG', false);

    function v($val) {
        if (DEBUG){
        echo '<pre>';
        var_dump($val);
        echo "</pre>";

        }
    }

?>
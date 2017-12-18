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



    // // 定数
    // define('DEBUG', true);
    // //falseにするとvardumpがoffになる。
    // //trueにするとvardumpがonになる。

    // DEBUG

    // function v($val){
    //   if (DEBUG) {
    //   echo'<pre>';
    //   var_dump($val);
    //   echo'</pre>';
    //   }
    // }
?>
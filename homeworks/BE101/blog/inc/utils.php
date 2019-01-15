<?php

function printMessage($msg, $redirect = 'default') {

    if($redirect === 'default' && isset($_SERVER['HTTP_REFERER'])) {
        $url = $_SERVER['HTTP_REFERER'];
        echo "<script>alert('$msg');";
        echo "window.location.href='$url'";
        echo "</script>";
    } else {
        $url = $redirect;
        echo "<script>";
        echo "alert('$msg');";
        echo "window.location.href='$url'";
        echo "</script>";
    }

}




?>
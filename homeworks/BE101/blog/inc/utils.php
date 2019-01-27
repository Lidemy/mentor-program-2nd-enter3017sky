<?php

/** 檢查是否有登入，如果沒有的話，POST GET 方法傳來的參數都註銷，預設導回首頁 */
function checkLoginAndPrintMsg($user, $errorMsg = '有什麼地方不對勁！？', $redirect = '') {
    if(empty($redirect)) {
        $redirect = './index.php';
    }
    if(!isset($user) && empty($user)) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            printMessage($errorMsg, $redirect);
            return $_POST = null;
        } else if($_SERVER['REQUEST_METHOD'] === 'GET') {
            printMessage($errorMsg, $redirect);
            return $_GET = null;
        }
    }
}


// blog 搜尋用：擷取關鍵字前後 150 字元。
function catchStr($str, $key) {
    $staPos = stripos($str, $key);
    if($staPos < 150) {
        $result = mb_substr($str, 0, 300, 'UTF-8');
        return $result;
    } else {
        $result = mb_substr($str, $staPos-150, $staPos+150, 'UTF-8');
        return $result;
    }
}


function printMessage($msg, $redirect = '') {
    if($redirect === '' && isset($_SERVER['HTTP_REFERER'])) {
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

// escape function 跳脫字元。ENT_QUOTES: 單引號、雙引號都進行編碼。
function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}






?>
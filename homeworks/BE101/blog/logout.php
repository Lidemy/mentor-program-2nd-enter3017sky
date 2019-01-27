<?php

session_start();
unset($_SESSION['username']);
session_unset();
session_destroy();

function DeleteAllCookies() {
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, null);
    }
}
DeleteAllCookies();

header('Location: index.php');


exit;
?>
<nav class="nav">
    <ul class="nav__list nav__left">
        <li class="nav__item">
            <a href="./index.php">回首頁</a>
        </li>
    </ul>
    <ul class="nav__list nav__right">
        <li class="nav__item">
            <a href="./register.php">註冊</a>
        </li>
        <li class="nav__item">
            <!-- 先檢查有沒有設定，就不會跳(沒有這個變數)錯誤訊息 -->
            <?php if(isset($user) && !empty($user)) { ?>
                <a href="./logout.php">登出</a>
            <?php } else { ?>
                <a href="./login.php">登入</a>
            <?php } ?>
        </li>
    </ul>
</nav>
<?php require_once './check_login.php'; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-white position-fixed w-100">
    <a class="navbar-brand" href="#">Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="archives.php">Archives</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="categories.php">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
            </li>
<?php if(isset($user) && !empty($user)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong>Admin</strong></a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="./admin.php">文章管理</a>
                    <a class="dropdown-item" href="./admin_category.php">分類管理</a>
                <div class="dropdown-divider"></div> <!-- 分隔線 -->
                    <a class="dropdown-item" href="./add.php">新增文章</a>
                    <a class="dropdown-item" href="./add_category.php">新增分類</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="./edit_about.php">編輯 About Me</a>
                </div>
            </li>
            <a class="btn btn-outline-secondary ml-2" href="./logout.php">Log out</a>
        </ul>
<?php } else { ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Log in</a>
            </li>
        </ul>
<?php } ?>
        <form class="form-inline my-2 my-lg-0" method="GET" action="./handle_search.php">
            <input class="form-control mr-sm-2" type="search" placeholder="Search Blog..." aria-label="Search" name='q'>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>


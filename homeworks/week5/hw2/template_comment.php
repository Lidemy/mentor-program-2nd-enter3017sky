<!-- 插入留言(comment)及子留言(subcomment) -->
<div class='meg__commnet'>
    <div class='meg__wrap'>
        <div class='meg__commnet-header'>
            <!-- 插入暱稱 以及 留言時間 -->
            <div class='meg__commnet-author'><?php echo $row['nickname'] ?></div> 
            <div class='meg__commnet-timestmp'><?php echo $row['created_at'] ?></div>
        </div>
        <div class="meg__commnet-content">  <!-- 使用 htmlspecialchars 函式轉換字元 -->
            <?php echo htmlspecialchars($row['content'], ENT_QUOTES, 'utf-8') ?>
        </div>
    </div>

<?php
    $parent_id = $row['id'];    // 子留言
    // 定義一個新的變數

    $sql_child = "SELECT enter3017sky_comments.*, enter3017sky_user.nickname 
    FROM enter3017sky_comments LEFT JOIN enter3017sky_user ON enter3017sky_user.id = enter3017sky_comments.user_id
    WHERE parent_id = $parent_id ORDER BY created_at DESC";
    $result_child = $conn->query($sql_child);

    while ($sub_comment = $result_child->fetch_assoc()) {    // output data of each row
        include("template_subcomment.php");        //引入子留言的區塊
    }
?>
    <div class='form__wrap'>
        <form method="POST" action="/enter3017sky/week5/add_comment.php">
            <label name="content">
                <div class='meg__form-textarea'>
                    <textarea name='content' type='textarea' placeholder="留言內容"></textarea>
                </div>
            </label>
            <input name='parent_id' type='hidden' value="<?php echo $row['id'] ?>" />
<?php
    if ($is_login) {
        echo "<input class='meg__form-submit' type='submit' value='提交' />";
    } else {
        echo "<input class='meg__form-submit' type='submit' value='請先登入' disabled />";
    }
?>
        </form>
    </div>
</div>
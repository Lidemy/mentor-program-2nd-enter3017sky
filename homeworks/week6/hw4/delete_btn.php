<div class="delete__comment">
    <form method="POST" action="./delete_comment.php">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <input type="submit" value="刪除" class="delete__btn">
    </form>
</div>
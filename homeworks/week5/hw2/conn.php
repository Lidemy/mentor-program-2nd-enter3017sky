<!-- 連到 datebase -->

<?php
// 本地資料庫
// $db_host = "localhost";
// $db_username = "root";
// $db_password = "";
// $db_name = "mentor_program_db";



// 作業用的資料庫，phpmyadmin 網址：
// http://mentor-program.co/huli/phpmyadmin/index.php
$db_host = "localhost";
$db_username = "student2nd";
$db_password = "mentorstudent123";
$db_name = "mentor_program_db";


// 建立連接
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
$conn->query("SET NAMES 'UTF8'");
// $conn->query("set time_zone = '+8:00'");


// 檢查連接
// conn 的 連接錯誤  就 die 不執行 跳你設定的錯誤訊息
if ($conn->connect_error) {
    die("資料庫連接失敗(Connection failed)" . $conn->connect_error);
}
// echo "資料庫連接成功(Connected successfully)";

?>

<?php
    include_once('./check_login.php');
    require_once('./conn.php');
    require_once('./utils.php');


    // echo 'success';
    // exit();

    // header("Content-type: application/json");

    if (
        isset($_POST['content']) && 
        !empty($_POST['content'])
    ){
        // if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $content = $_POST['content'];
            $parent_id = $_POST['parent_id'];
            $nick = $_SESSION['nickname'];
            // $username = $_COOKIE['username'];

            // echo json_encode(array(
            //     'content' => $content,
            //     'parent_id' => $parent_id,
            // ));

            // 新增留言
            $sql = "INSERT INTO enter3017sky_comments(username, content, parent_id)
             VALUES(?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $user, $content, $parent_id);

            if ($stmt->execute()) {
                // server redirect ，PHP的重新導向
                // header('location:./index.php');
                
                //  取得最後一筆輸入的 id
                $last_id = $conn->insert_id;
                // if($parent_id === '0'){
                    $arr = array(
                        'result' => 'Success',
                        'message' => 'Successfully Added',
                        'user' => $user,
                        'Request_Method' => $_SERVER['REQUEST_METHOD'],
                        'parent_id' => $parent_id,
                        'content' => $content,
                        'id' => $last_id,
                        'nick' => $nick
                    );
                    echo json_encode($arr);
                // } else {
                    // header('location:./index.php');
                //     $arr = array('result' => 'Error');
                //     echo json_encode($arr);
                // };
            
            } else {
                // JavaScript 的重新導向
                // printMessage($conn->error, './index.php');
                echo json_encode(array(
                    'result' => 'Fail',
                    'message' => 'Added Failure'
                ));
            };

        } else {
            // printMessage('請輸入內容!!', './index.php');
            echo json_encode(array(
                'result' => 'failure',
                'message' => 'MySql add fail',
                // 'content' => $content,
                // 'parent_id' => $parent_id,
            ));
        };




?>
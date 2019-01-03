<?php
    require_once '../job_board/conn.php';

    if (isset($_GET['update'])) {
        $value = $_GET['update'];
        $message = null;
        $flag = false;

        if ($value === "reset") {
            try {
                    // 重置所有數量
                $reset_sql = "UPDATE products SET amount = 3, selled = 0 WHERE id < 5";
                $reset_sql2 = "UPDATE products SET amount = 2, selled = 0  WHERE id = 5";
                // $stmt = $pdo->prepare($sql);
                // $stmt->execute(array($value));

                // chain 的方式
                $pdo->prepare($reset_sql)->execute();
                $pdo->prepare($reset_sql2)->execute();

                // 並且刪除訂單
                $delete_sql = "DELETE FROM orders";
                // 方法一 exec() 執行 SQL，返回受影響的行數，用 $deleted !== 0 的方式判斷
                $deleted = $pdo->exec($delete_sql);

                // 方法二 rowCount();
                // 使用 PDOStatement 類別的 rowCount() 的話，$pdo->query($delete_sql)顯示不出影響的筆數; 
                // $stmt = $pdo->prepare($delete_sql);
                // $stmt->execute();
                // $deleted = $stmt->rowCount();
                // $message = "刪除 $deleted 筆商品的訂單，重置庫存成功";
                
                if($deleted !== 0) {
                    $message = "刪除 $deleted 筆商品的訂單，重置庫存成功";
                } else {
                    $message = "$deleted 筆訂單，已重置了";
                }

            } catch (PDOException $e) {
                echo "<br/>";
                echo '<pre>';
                echo 'PDO Exception Caught: ';
                echo "Error with the database:<br>";
                echo 'SQL Query:'.$delete_sql.'<br>';
                echo "ERROR:".$e->getMessage().'<br>';
                echo "Code:".$e->getCode().'<br>';
                echo "File:".$e->getFile().'<br>';
                echo "Line:".$e->getLine().'<br>';
                echo "Trace:".$e->getTraceAsString().'<br>';
                echo '</pre>';
            }
        }
        
        if ($value === "general") {
            try {
                //開始交易
                $pdo->beginTransaction(); 
                $transaction_success = null;

                // 新增訂單
                $add_order = "INSERT INTO orders (product_id, amount, price)VALUE(?, ?, ?)";
                
                // 更新商品庫存及售出的數量
                $update_amount = "UPDATE products SET amount = amount - 1, selled = selled + 1 WHERE id = ? AND amount > 0";

                // 更新訂單的數量
                $update_order = "UPDATE orders o JOIN products p ON o.product_id=p.id 
                    SET o.amount = o.amount + 1  WHERE o.product_id = ? AND o.amount=p.selled AND p.amount > 0";

                // 檢查有沒有訂單
                $check_order = "SELECT product_id FROM orders where product_id = ?";

                $products_arr = ([
                    1 => [1, 1, 200],
                    2 => [2, 1, 500],
                    3 => [3, 1, 400],
                    4 => [4, 1, 500],
                    5 => [5, 1, 600]
                ]);

                // print_r([$products_arr[1]]);
                // print_r([1]);
                // print_r([1, 3, 200]);
                // print_r(array(1, 3, 200));

                for($i = 1; $i <= 5; $i++) {
                    $is_order = query($pdo, $check_order, [$i], 'rows');
                    if($is_order) {
                        $result = query($pdo, $update_order, [$i], 'count');
                        if ($result) {
                            $pdo->prepare($update_amount)->execute([$i]);
                            $transaction_success = true;
                        } else {
                            $transaction_success = false;
                        }
                    } else {
                        $result = $pdo->prepare($update_amount)->execute([$i]);
                        if ($result) {
                            $pdo->prepare($add_order)->execute($products_arr[$i]);
                            $transaction_success = true;
                        }
                    }
                }

                if ($transaction_success) {
                    $pdo->commit();
                    $message = "購買成功！";
                    $flag = true;
                } else {
                    $pdo->rollback();
                    $message = "購買失敗，由於某樣商品缺貨！";
                    // $flag = false;
                    $flag = true;
                }

            } catch (PDOException $e) {
                echo "<br/>";
                echo '<pre>';
                echo 'PDO Exception Caught: ';
                echo "Error with the database:<br>";
                // echo 'SQL Query:'.$delete_sql.'<br>';
                echo "ERROR:".$e->getMessage().'<br>';
                echo "Code:".$e->getCode().'<br>';
                echo "File:".$e->getFile().'<br>';
                echo "Line:".$e->getLine().'<br>';
                echo "Trace:".$e->getTraceAsString().'<br>';
                echo '</pre>';
                throw $e;
            }
        }

        if ($value === "over") {
            $sql = "UPDATE products SET amount = amount - 3";
            $stmt = $pdo->prepare($sql)->execute();
            $order = "INSERT INTO orders (product_id, amount, price)VALUE(?, ?, ?)";
            $products_arr = ([
                1 => [1, 3, 200],
                2 => [2, 3, 500],
                3 => [3, 3, 400],
                4 => [4, 3, 500],
                5 => [5, 3, 600]
            ]);

            for ($i = 1; $i <= 5; $i++) {
                $pdo->prepare($order)->execute($products_arr[$i]);
            }
                $message = '似乎有什麼地方出錯了..';
                $flag = true;

            // $pdo->prepare($order)->execute(array(1, 3, 200));
            // $pdo->prepare($order)->execute(array(2, 3, 500));
            // $pdo->prepare($order)->execute(array(3, 3, 400));
            // $pdo->prepare($order)->execute(array(4, 3, 500));
            // $pdo->prepare($order)->execute(array(5, 3, 600));

          
        }
    }

function query($pdo, $sql, $params, $return) {
    // Prepare statement
    $stmt = $pdo->prepare($sql);
    // Execute statement
    $stmt->execute($params);
    // Decide whether to return the rows themselves, or just count the rows
    if ($return == "rows") {
        return $stmt->fetchAll();
    } else if ($return == "count") {
        return $stmt->rowCount();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>購物車</title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="style.css" /> -->
</head>
<body>
    <div class="container mt-5">
        <div class="w-75 mx-auto">
            <div class='card card-body'>
                <h2 class='card-title'>庫存</h2>
                <table border='1'>
                    <?php
                        $sql = "SELECT * FROM products";
                        $result = $pdo->query($sql);
                        if($result->rowCount() > 0) {
                            while ($row = $result->fetch()) {
                                print "
                                <tr>
                                    <td>商品名稱：" . $row['name'] . "</td>
                                    <td>商品數量:" . $row['amount'] . "</td>
                                </tr>";
                            }
                        }
                    ?>
                </table>
            </div>

            <?php
                // 也可利用 $value 判斷
                if(isset($message)) {
                    // if($value == 'reset' || $value == 'over') {
                    //     print "
                    //     <div class='card card-body m-4 mx-auto'>
                    //         <h5 class='text-muted mx-auto'>
                    //             $message
                    //         </h5>
                    //     </div>
                    //     ";
                    // } 
                    
                    //  改成都能看到購買的訂單

                    if($value == "general" || $value == 'reset' || $value == 'over') {
                        print "
                            <div class='card card-body m-4 mx-auto'>
                                <h5 class='text-muted mx-auto'>
                                    $message
                                </h5>
                                <table border='1'>
                                ";

                        if($flag) {
                            $sql = "SELECT o.product_id, p.name, o.price , o.amount
                                FROM orders AS o 
                                JOIN products AS p
                                WHERE o.product_id = p.id
                                ORDER BY o.id ASC";
                            $result = $pdo->query($sql);
                            while ($row = $result->fetch()) {
                                print "
                                <tr>
                                    <td width='50%'>購買商品： " . $row['name'] . "</td>
                                    <td width='30%'>購買價格： " . $row['price'] . "</td>
                                    <td width='20%'>購買數量： " . $row['amount'] . "</td>
                                </tr>
                                ";
                            }
                        }
                        print "
                            </table>
                        </div>
                        ";
                    }
                }
            ?>

            <div class="card card-body p-4 m-4 mx-auto">
                <div class="form-row">
                    <div class="form-group col col-md-12">
                        <form class="form-inline" method="get" action="week8_hw3_3.php">
                            <div class="col-md-8">
                                <h5>重置庫存</h5>
                                <input type="hidden" name="update" value="reset">
                            </div>
                            <button type="submit" class="btn btn-primary col-md-4 col-sm-12">提交</button>
                        </form>
                    </div>
                    <div class="form-group col col-md-12">
                        <form class="form-inline" method="get" action="week8_hw3_3.php">
                            <div class="col-md-8">
                                <h5>一般購買</h5>
                                <input type="hidden" name="update" value="general">
                            </div>
                            <button type="submit" class="btn btn-primary col-md-4 col-sm-12">提交</button>
                        </form>
                    </div>
                    <div class="form-group col col-md-12">
                        <form class="form-inline" method="get" action="week8_hw3_3.php">
                            <div class="col-md-8">
                                <h5>超量購買</h5>
                                <input type="hidden" name="update" value="over">
                            </div>
                            <button type="submit" class="btn btn-primary col-md-4 col-sm-12">提交</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


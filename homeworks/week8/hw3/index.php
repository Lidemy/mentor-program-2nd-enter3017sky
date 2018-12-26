<?php
    require_once '../job_board/conn.php';

    if(isset($_GET['update'])) {

        $value = $_GET['update'];
        $is_success = false;
        $message = null;

        if($value == 1) {
            // 重置
            $sql = "UPDATE products SET amount=?";
            // $stmt = $pdo->prepare($sql);
            // $stmt->execute(array($value));

            // china 的方式
            $pdo->prepare($sql)->execute(array($value));


            $sql = "DELETE FROM orders";
            $pdo->query($sql)->execute();

            $message = "重置庫存";

        } 
        // else if($value == 2) {

        // }
         else if($value == 3) {

            // 先查詢 products 的 amount 的數量
            $sql = "SELECT amount FROM products";
            $stmt = $pdo->query($sql);
            $stmt->execute();

            if($row = $stmt->fetch()) {
                // 每個 row 的 amount > 0 才會執行 
                if($row['amount'] > 0) {

                    try {
                        $pdo->beginTransaction(); //開始交易
                        $sql = "UPDATE products SET amount = amount - ?";
                        // $sql = "UPDATE products SET amount = ?";  amount-1 怪怪的
                        $stmt = $pdo->prepare($sql)->execute(array(1));

                        $order = "INSERT INTO orders (product_id, amount, price)VALUE(?, ?, ?)";
                        $pdo->prepare($order)->execute(array(1, 1, 200));
                        $pdo->prepare($order)->execute(array(2, 1, 500));
                        $pdo->prepare($order)->execute(array(3, 1, 400));
                        $pdo->prepare($order)->execute(array(4, 1, 500));
                        $pdo->prepare($order)->execute(array(5, 1, 600));

                        $pdo->commit();
                        $message = "購買成功！";
                        $is_success = true;

                    } catch(PDOException $e) {
                        $pdo->rollback();
                        $message = "購買失敗";
                    }

                } else {
                    $message = "某樣商品缺貨中";
                }
            }

        } else if($value == 4) {

            $sql = "UPDATE products SET amount = amount - ?";
            // $sql = "UPDATE products SET amount = ?";  amount-1 怪怪的
            $stmt = $pdo->prepare($sql)->execute(array(1));

            $order = "INSERT INTO orders (product_id, amount, price)VALUE(?, ?, ?)";
            $pdo->prepare($order)->execute(array(1, 1, 200));
            $pdo->prepare($order)->execute(array(2, 1, 500));
            $pdo->prepare($order)->execute(array(3, 1, 400));
            $pdo->prepare($order)->execute(array(4, 1, 500));
            $pdo->prepare($order)->execute(array(5, 1, 600));

            $message = '似乎有什麼地方出錯了..';
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
                    if($value == 1 || $value == 4) {
                        print "
                        <div class='card card-body m-4 mx-auto'>
                            <h3 class='text-muted mx-auto'>
                                $message
                            </h3>
                        </div>
                        ";
                    } 

                    if($value == 3) {
                        print "
                            <div class='card card-body m-4 mx-auto'>
                                <h3 class='text-muted mx-auto'>
                                    $message
                                </h3>
                                <table border='1'>
                                ";

                        if($is_success) {
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

                    // if($value == 4) {
                    //     print "
                    //         <div class='card card-body m-4 mx-auto'>
                    //             <h3 class='text-muted mx-auto'>
                    //                 $message
                    //             </h3>
                    //             <table border='1'>
                    //             ";

                    //     $sql = "SELECT o.product_id, p.name, o.price , o.amount
                    //     FROM orders AS o 
                    //     JOIN products AS p
                    //     WHERE o.product_id = p.id
                    //     ORDER BY o.id ASC";

                    //     $result = $pdo->query($sql);

                    //         while ($row = $result->fetch()) {
                    //             print "
                    //             <tr>
                    //                 <td width='50%'>購買商品： " . $row['name'] . "</td>
                    //                 <td width='30%'>購買價格： " . $row['price'] . "</td>
                    //                 <td width='20%'>購買數量： " . $row['amount'] . "</td>
                    //             </tr>
                    //             ";
                    //         }
                    //     print "
                    //         </table>
                    //     </div>
                    //     ";
                    // }

                }
            ?>

            <div class="card card-body p-4 m-4 mx-auto">
                <form class="form-inline ml-5 p-3" method="get" action="index.php">
                    <div class="form-group mr-5">
                        <h3>重置庫存</h3>
                        <input type="hidden" name="update" value="1">
                    </div>
                    <button type="submit" class="btn btn-primary col-md-6 col-sm-12">提交</button>
                </form>

                <!-- <form class="form-inline ml-5 p-3" method="get" action="index.php">
                    <div class="form-group mr-5">
                        <h3>顯示庫存</h3>
                        <input type="hidden" name="update" value="2">
                    </div>
                    <button type="submit" class="btn btn-primary col-md-6 col-sm-12">提交</button>
                </form> -->

                <form class="form-inline ml-5 p-3" method="get" action="index.php">
                    <div class="form-group mr-5">
                        <h3>一般購買</h3>
                        <input type="hidden" name="update" value="3">
                    </div>
                    <button type="submit" class="btn btn-primary col-md-6 col-sm-12">提交</button>
                </form>
                <form class="form-inline ml-5 p-3" method="get" action="index.php">
                    <div class="form-group mr-5">
                        <h3>超量購買</h3>
                        <input type="hidden" name="update" value="4">
                    </div>
                    <button type="submit" class="btn btn-primary col-md-6 col-sm-12">提交</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


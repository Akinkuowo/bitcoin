<?php
session_start();
            $id = $_SESSION['id'];
            $amount = $_SESSION['amount'];
            $coin = "BCH";
            $date = date("y/m/d");
            $details = $_SESSION['current'];
            $usd = $_SESSION['price'];
            
            function createToken($len=32){
                return substr(md5(openssl_random_pseudo_bytes(30)), -$len);
            }
            $transaction_id = createToken(20);
           

             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $wallet = $row["bitcoin_cash"];
                $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$amount', '$coin', '$date', '$id', '$usd', '$wallet', '$transaction_id','towallet', 'buy')";
                $run_query = mysqli_query($conn, $sql);
                if($run_query == 1){
                    header("Location: ../users/pay-with-pm.php");
                }else{
                    echo "no";
                }
            }


    // 



?>


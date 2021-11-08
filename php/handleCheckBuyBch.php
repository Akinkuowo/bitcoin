<?php
session_start();
            $id = $_SESSION['id'];
            
             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $wallet = $row["bitcoin_cash"];
                if($wallet == "No wallet"){
                     header("Location: ../users/buy.php?error= You don't have a BCH wallet address, kindly create a BCH wallet to buy BCH");
                }else if($wallet == "Wallet address is in process"){
                    header("Location: ../users/buy.php?error= BCH wallet address is in process, try again later");
                }else{
                    header("Location: ../users/bitcoincash-buy.php");
                }
               
            }


?>


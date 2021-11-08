<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/buy-ripple-with-bitcoincash.php?error=Kindly input how much ripple you want to buy"); 
        }else{
             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $RippleBalance = $row['ripple_amount'];
                $bitcoinCashBalance = $row['bitcoin_cash_amount'];
                $rippleAmount = $amount * 0.65;
                $bitcoinCash = $rippleAmount / 497;

                if($bitcoinCash > $bitcoinCashBalance){
                    header("location: ../users/buy-ripple-with-bitcoincash.php?error=Insufficient bitcoin cash balance, Kindly fund your wallet to complete transaction"); 
                }else{
                   
                    $rippleNewBalance = $RippleBalance + $amount;
                    $bitcoinCashNewbalance = $bitcoinCashBalance - $bitcoinCash;

                    $sql = "UPDATE `users` SET  bitcoin_cash_amount='$bitcoinCashNewbalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ripple_amount='$rippleNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount ripple purchased successfully"); 
                        }else{
                            header("location: ../users/buy-ripple-with-bitcoincash.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/buy-ripple-with-bitcoincash.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>
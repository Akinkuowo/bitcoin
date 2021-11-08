<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/buy-bitcoin-with-bitcoincash.php?error=Kindly input how much Bitcoin you want to buy"); 
        }else{
            $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $BitcoinBalance = $row['bitcoin_amount'];
                $bitcoinCashBalance = $row['bitcoin_cash_amount'];
                
                $bitcoinAmount = $amount * 32162;
                $bitcoinCash = $bitcoinAmount / 497;

                if($bitcoinCash > $bitcoinCashBalance){
                    header("location: ../users/buy-bitcoin-with-bitcoincash.php?error=Insufficient Bitcoin Cash Balance, kindly fund your bitcoin cash wallet to complete transaction"); 
                }else{
                   
                     $bitcoinNewBalance = $BitcoinBalance + $amount;
                     $bitcoinCashNewBalance = $bitcoinCashBalance - $bitcoinCash;
                  
 
                     $sql = "UPDATE `users` SET  bitcoin_amount='$bitcoinNewBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);
                     if($run_query == 1){
 
                         $sql = "UPDATE `users` SET  bitcoin_cash_amount='$bitcoinCashNewBalance' WHERE id='$id'";
                         $run_query = mysqli_query($conn, $sql);
                         
                         if($run_query == 1){
                             header("location: ../users/wallets.php?success=$amount bitcoin purchased successfully"); 
                         }else{
                             header("location: ../users/wallets.php?error=An error occur"); 
                         }
                     }
                 
                }

                   
            }
        }
      
   }else{

      echo "no";
   }

?>
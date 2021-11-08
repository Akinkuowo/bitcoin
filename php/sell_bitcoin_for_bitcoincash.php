<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/sell-bitcoin-for-bitcoincash.php?error=Kindly input how much Bitcoin Cash you want to sell"); 
        }else{
              $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $bitcoinBalance = $row['bitcoin_amount'];
                $bitcoinCashBalance = $row['bitcoin_cash_amount'];
                
                $bitcoinAmount = $amount * 32162;
                $bitcoinCash = $bitcoinCashAmount / 497;

                if($amount > $bitcoinBalance){
                    header("location: ../users/sell-bitcoin-for-bitcoincash.php?error=Insufficient BitcoinBalance, Kindly fund your wallet to complete transaction"); 
                }else{
                   
                     $bitcoinNewBalance = $bitcoinBalance - $amount;
                     $bitcoinCashNewBalance = $bitcoinCashBalance + $bitcoinCash;
                  
 
                     $sql = "UPDATE `users` SET  bitcoin_amount='$bitcoinNewBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);
                     if($run_query == 1){
 
                         $sql = "UPDATE `users` SET  bitcoin_cash_amount='$bitcoinCashNewBalance' WHERE id='$id'";
                         $run_query = mysqli_query($conn, $sql);
                         
                         if($run_query == 1){
                             header("location: ../users/wallets.php?success=$amount bitcoin sold successfully"); 
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